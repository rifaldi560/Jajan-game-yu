<?php
namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


    class ProdukController extends Controller
    {
        public function index(Request $request)
    {
        $kategoris = Kategori::all();
        $produkQuery = Produk::with('kategori');

        // Filter berdasarkan keyword pencarian
        if ($request->filled('search')) {
            $produkQuery->where(function($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhereHas('kategori', function ($q) use ($request) {
                        $q->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $produkQuery->where('kategori_id', $request->kategori);
        }

        $produks = $produkQuery->paginate(10)->appends($request->query());

        return view('home', compact('produks', 'kategoris'));
    }


        public function create()
        {
            $kategoris = Kategori::all();
            return view('produk.create', compact('kategoris'));
        }

public function store(Request $request)
{
    $request->validate([
        'kode_produk' => 'required|string|max:255|unique:produks,kode_produk',
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'kategori_id' => 'required|exists:kategoris,id',
        'itch_io_link' => 'nullable|url',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'file_game' => 'nullable|file|mimes:zip|max:51200', // max 50MB
        'deskripsi' => 'nullable|string',
    ]);

    $data = $request->only(['kode_produk', 'nama', 'harga', 'kategori_id', 'itch_io_link', 'deskripsi']);

    // Upload gambar (jika ada)
    if ($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('gambar_produk', 'public');
        $data['gambar'] = $gambarPath;
    }

    // Upload dan ekstrak file game (jika ada)
    if ($request->hasFile('file_game')) {
        $zip = $request->file('file_game');
        $zipName = Str::uuid();
        $zipPath = storage_path('app/public/games_zip/' . $zipName . '.zip');
        $extractPath = storage_path('app/public/games_extracted/' . $zipName);

        // Simpan zip
        $zip->move(storage_path('app/public/games_zip'), $zipName . '.zip');

        // Ekstrak
        $zipArchive = new ZipArchive;
        if ($zipArchive->open($zipPath) === TRUE) {
            $zipArchive->extractTo($extractPath);
            $zipArchive->close();
            $data['file_game'] = 'games_extracted/' . $zipName;
        } else {
            return back()->with('error', 'Gagal mengekstrak file ZIP.');
        }
    }

    Produk::create($data);

    return redirect()->route('admin.home')->with('success', 'Produk berhasil ditambahkan.');
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

    // Validasi data umum
    $request->validate([
        'kode_produk' => 'required',
        'nama' => 'required',
        'harga' => 'required|numeric|min:0',
        'kategori_id' => 'required|exists:kategoris,id',
        'itch_io_link' => 'required|url',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image',
        'file_game' => 'nullable|mimes:zip|max:500000',
    ]);

    // Proses file ZIP jika ada
    if ($request->hasFile('file_game')) {
        $zip = new \ZipArchive;
        $zipFile = $request->file('file_game');
        $folderName = 'game_' . time();
        $extractPath = public_path('games/' . $folderName);

        if ($zip->open($zipFile) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();

            // Hapus folder lama jika ada
            if ($produk->file_game && File::exists(public_path('games/' . $produk->file_game))) {
                File::deleteDirectory(public_path('games/' . $produk->file_game));
            }

            $produk->file_game = $folderName;
        } else {
            return back()->with('error', 'Gagal mengekstrak file ZIP.');
        }
    }

    // Proses gambar jika ada
    if ($request->hasFile('gambar')) {
        if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
            Storage::delete('public/' . $produk->gambar);
        }

        $gambarPath = $request->file('gambar')->store('gambar_produk', 'public');
        $produk->gambar = $gambarPath;
    }

    // Simpan data lainnya
    $produk->kode_produk = $request->kode_produk;
    $produk->nama = $request->nama;
    $produk->harga = $request->harga;
    $produk->kategori_id = $request->kategori_id;
    $produk->itch_io_link = $request->itch_io_link;
    $produk->deskripsi = $request->deskripsi;

    // ⬅️ YANG PENTING: simpan ke database!
    $produk->save();

    return redirect()->route('admin.home')->with('success', 'Produk berhasil diperbarui.');
}

        public function show($id)
        {
            $produk = Produk::findOrFail($id);
            return view('produk.show', compact('produk'));
        }

    public function downloadGame($id)
    {
        $produk = Produk::findOrFail($id);

        if (!$produk->file_game || !Storage::disk('public')->exists($produk->file_game)) {
            abort(404, 'File game tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($produk->file_game);
        return response()->download($filePath);
    }


        public function play($id)
    {
        $produk = Produk::findOrFail($id);
        $folder = $produk->file_game;

        if (!$folder || !File::exists(public_path("games/{$folder}/index.html"))) {
            abort(404, 'File game tidak ditemukan.');
        }

        return view('produk.play', compact('folder', 'produk'));
    }
    // app/Http/Controllers/ProdukController.php

public function destroy($id)
{
    $produk = Produk::findOrFail($id);
    $produk->delete();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
}


    }
