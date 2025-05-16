<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Produk;

class StorageController extends Controller
{
    /**
     * Mengunduh file game yang terkait dengan produk.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadGame($id)
    {
        $produk = Produk::findOrFail($id);

        if (!$produk->file_game || !Storage::disk('public')->exists($produk->file_game)) {
            abort(404, 'File game tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($produk->file_game);
        return response()->download($filePath);
    }

    /**
     * Menghapus file game yang terkait dengan produk.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteGame($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->file_game && Storage::disk('public')->exists($produk->file_game)) {
            Storage::disk('public')->delete($produk->file_game);
        }

        $produk->file_game = null; // Hapus referensi file_game dari database
        $produk->save();

        return redirect()->route('admin.home')->with('success', 'File game berhasil dihapus');
    }
}
