<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Pastikan ini ada

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::all();
        $produkQuery = Produk::with('kategori');
        $produks = Produk::all();

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
        $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string|max:1000',
            'itch_io_link' => 'required|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['kode_produk', 'nama', 'harga', 'kategori_id', 'deskripsi', 'itch_io_link']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gambar_produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.home')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();

        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,' . $id,
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string|max:1000',
            'itch_io_link' => 'required|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $produk = Produk::findOrFail($id);
        $data = $request->only(['kode_produk', 'nama', 'harga', 'kategori_id', 'deskripsi', 'itch_io_link']);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(storage_path('app/public/' . $produk->gambar))) {
                unlink(storage_path('app/public/' . $produk->gambar));
            }
            $data['gambar'] = $request->file('gambar')->store('gambar_produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('admin.home')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar && file_exists(storage_path('app/public/' . $produk->gambar))) {
            unlink(storage_path('app/public/' . $produk->gambar));
        }

        $produk->delete();

        return redirect()->route('admin.home')->with('success', 'Produk berhasil dihapus');
    }
    public function show($id)
{
    $produk = Produk::findOrFail($id);
    return view('produk.show', compact('produk'));
}

}
