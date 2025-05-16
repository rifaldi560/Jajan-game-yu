<?php

namespace App\Providers;

use App\Models\Produk;
use App\Policies\ProdukPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Produk::class => ProdukPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
