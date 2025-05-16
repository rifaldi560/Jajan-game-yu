<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProdukPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the produk.
     */
    public function update(User $user, Produk $produk): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the produk.
     */
    public function delete(User $user, Produk $produk): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Allow only admin to view all products in admin dashboard.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }
}
