<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk', 'nama', 'harga', 'kategori_id', 'deskripsi', 'itch_io_link', 'gambar'
    ];
    // Relasi Many-to-One: Produk memiliki satu Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
