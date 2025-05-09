<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'items',
        'total_harga',
        'status',
        'resi',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   // app/Models/Transactions.php

public function product()
{
    return $this->belongsTo(Produk::class, 'kode_produk'); // pastikan kolom foreign key benar
}


}
