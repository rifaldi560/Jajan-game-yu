<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Menggunakan 'role' bukan 'type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Cek apakah user memiliki role tertentu.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        // Replace this logic with your own role-checking logic
        return $this->role === $role;
    }
}
