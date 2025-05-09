<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan HasFactory diimpor dengan benar

class Kategori extends Model
{
    use HasFactory;  // Menambahkan trait HasFactory untuk mendukung factory

    // Menambahkan 'nama' ke dalam array fillable untuk mengizinkan mass assignment
    protected $fillable = ['nama'];

    // Relasi One-to-Many: Kategori memiliki banyak Produk
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
