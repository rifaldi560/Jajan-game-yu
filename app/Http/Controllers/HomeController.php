<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;


class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama untuk user biasa.
     */public function index(Request $request)
{
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role == 'admin') {
            return redirect()->route('admin.home');
        } elseif ($user->role == 'manager') {
            return redirect()->route('manager.home');
        } else {
            // Ambil semua kategori
            $kategoris = Kategori::all();

            // Query produk
            $produkQuery = Produk::query();

            // Filter berdasarkan kategori jika ada
            if ($request->filled('kategori_id')) {
                $produkQuery->where('kategori_id', $request->kategori_id);
            }

            // Filter berdasarkan pencarian jika ada
            if ($request->filled('search')) {
                $produkQuery->where('nama', 'like', '%' . $request->search . '%');
            }

            $produks = $produkQuery->get();

            return view('home', compact('produks', 'kategoris'));
        }
    }

    return redirect()->route('login');
}
    /**
     * Menampilkan halaman utama untuk admin.
     */
    public function adminHome()
    {
        $produks = Produk::all(); // Mengambil semua produk
        return view('adminHome', compact('produks')); // Mengirim data ke view adminHome.blade.php
    }

    /**
     * Menampilkan halaman utama untuk manager.
     */
    public function managerHome()
    {
        $produks = Produk::all(); // Mengambil semua produk
        return view('managerHome', compact('produks')); // Mengirim data ke view managerHome.blade.php
    }
}
