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

    // Pastikan ada folder game
    if (!$produk->file_game || !is_dir(public_path('games/' . $produk->file_game))) {
        abort(404, 'File game tidak ditemukan');
    }

    $folderPath = public_path('games/' . $produk->file_game);
    $zipFile = storage_path('app/tmp/' . $produk->file_game . '.zip');

    // Buat folder tmp jika belum ada
    if (!file_exists(storage_path('app/tmp'))) {
        mkdir(storage_path('app/tmp'), 0777, true);
    }

    // Buat ZIP dari folder game
    $zip = new \ZipArchive;
    if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folderPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    } else {
        abort(500, 'Gagal membuat file ZIP.');
    }

    // Download ZIP lalu hapus setelah selesai
    return response()->download($zipFile)->deleteFileAfterSend(true);
}

public function deleteGame($id)
{
    $produk = Produk::findOrFail($id);
    $filePath = base_path('app/public/games/' . $produk->file_game);

    if ($produk->file_game && file_exists($filePath)) {
        unlink($filePath);
    }

    $produk->file_game = null;
    $produk->save();

    return redirect()->route('admin.home')->with('success', 'File game berhasil dihapus');
}
}
