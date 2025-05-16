<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::all();
        $produkQuery = Produk::with('kategori');

        if ($request->filled('search')) {
            $produkQuery->where(function($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%')
                      ->orWhereHas('kategori', function ($q) use ($request) {
                          $q->where('nama', 'like', '%' . $request->search . '%');
                      });
            });
        }

        $produks = $produkQuery->paginate(10);
        return view('home', compact('produks', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk',
            'nama' => 'required',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'itch_io_link' => 'required|url',
            'file_game' => 'nullable|file|mimes:zip',
            'gambar' => 'nullable|image',
            'deskripsi' => 'nullable|string',
        ]);

        $gambarName = $request->file('gambar') ? $request->file('gambar')->store('gambar_produk', 'public') : null;

        $extractedFolder = null;
        if ($request->hasFile('file_game')) {
            $file = $request->file('file_game');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/games_zip', $filename);

            $extractFolderName = pathinfo($filename, PATHINFO_FILENAME);
            $extractPath = storage_path("app/public/games_extracted/{$extractFolderName}");

            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip = new ZipArchive;
            if ($zip->open(storage_path("app/{$path}")) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
                $extractedFolder = 'games_extracted/' . $extractFolderName;
            } else {
                return back()->with('error', 'Gagal mengekstrak file ZIP.');
            }
        }

        Produk::create([
            'kode_produk' => $validated['kode_produk'],
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'kategori_id' => $validated['kategori_id'],
            'itch_io_link' => $validated['itch_io_link'],
            'file_game' => $extractedFolder,
            'gambar' => $gambarName,
            'deskripsi' => $validated['deskripsi'],
        ]);

        return redirect()->route('admin.home')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id);

    // Validasi input
    $validated = $request->validate([
        'kode_produk' => 'required|string|max:255',
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'kategori_id' => 'required|exists:kategoris,id',
        'itch_io_link' => 'nullable|url',
        'deskripsi' => 'nullable|string',
        'file_game' => 'nullable|file|mimes:zip',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Perbarui data produk
    $produk->kode_produk = $validated['kode_produk'];
    $produk->nama = $validated['nama'];
    $produk->harga = $validated['harga'];
    $produk->kategori_id = $validated['kategori_id'];
    $produk->itch_io_link = $validated['itch_io_link'];
    $produk->deskripsi = $validated['deskripsi'];

    // Perbarui file game jika ada
    if ($request->hasFile('file_game')) {
        // Hapus file game lama jika ada
        if ($produk->file_game && Storage::disk('public')->exists($produk->file_game)) {
            Storage::disk('public')->delete($produk->file_game);
        }

        // Simpan file game baru
        $produk->file_game = $request->file('file_game')->store('games', 'public');
    }

    // Perbarui gambar produk jika ada
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        // Simpan gambar baru
        $produk->gambar = $request->file('gambar')->store('gambar_produk', 'public');
    }

    // Simpan perubahan ke database
    $produk->save();

    // Redirect ke halaman admin.home dengan pesan sukses
    return redirect()->route('admin.home')->with('success', 'Produk berhasil diperbarui.');
}
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar) {
            Storage::delete('public/' . $produk->gambar);
        }

        if ($produk->file_game) {
            Storage::deleteDirectory('public/' . $produk->file_game);
        }

        $produk->delete();

        return redirect()->route('admin.home')->with('success', 'Produk berhasil dihapus');
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

   public function download($id)
{
    $produk = Produk::findOrFail($id);

    if (!$produk->file_game || !Storage::disk('public')->exists($produk->file_game)) {
        abort(404);
    }

    return response()->download(storage_path('app/public/' . $produk->file_game));
}


    public function play($id)
    {
        $produk = Produk::findOrFail($id);
        $indexPath = public_path("storage/{$produk->file_game}/index.html");

        if (!file_exists($indexPath)) {
            abort(404, 'File game tidak ditemukan.');
        }

        $url = asset("storage/{$produk->file_game}/index.html");
        return view('produk.play', compact('produk', 'url'));
    }
}
