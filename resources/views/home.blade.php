@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #171a21;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #c7d5e0;
    }

    .store-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .store-header h4 {
        font-size: 1.8rem;
        color: #66c0f4;
    }

    .card {
        background-color: #2a2f38;
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.75);
        min-height: 420px;
        display: flex;
        flex-direction: column;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        flex: 1;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-weight: bold;
        color: #ffffff;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .card-text {
        color: #c7d5e0;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
        flex-grow: 1;
    }

    .price-tag {
        font-size: 1rem;
        color: #a4d007;
        font-weight: bold;
        margin: 0.5rem 0;
    }

    .btn-game {
        font-size: 0.9rem;
        font-weight: bold;
        padding: 8px 14px;
        border-radius: 6px;
    }

    .btn-detail {
        background-color: #66c0f4;
        color: white;
        border: none;
    }

    .btn-beli {
        background-color: #a4de02;
        color: #000;
        border: none;
    }

    .btn-game:hover,
    .btn-detail:hover,
    .btn-beli:hover {
        filter: brightness(1.1);
    }

    .input-group input {
        background-color: #1b2838;
        border: 1px solid #66c0f4;
        color: #c7d5e0;
    }

    .btn-search {
        background-color: #66c0f4;
        color: white;
        border: none;
    }

    .alert-success {
        background-color: #4caf50;
        color: white;
    }

    .badge.bg-danger {
        background-color: #ff4c4c !important;
    }
</style>

<div class="container py-5">
    <div class="store-header">
        <h4>🎮 Maduriar Game Store</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-light btn-lg">
                <i class="fa fa-clock-rotate-left me-1"></i> Riwayat
            </a>
            <a href="{{ route('keranjang.index') }}" class="btn btn-warning position-relative btn-lg">
                <i class="fa fa-shopping-cart me-1"></i> Keranjang
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>
        </div>
    </div>
    <form action="{{ route('produk.index') }}" method="GET" class="mb-4 row g-2 align-items-center">
        <div class="col-md-8    ">
            <div class="input-group">

            </div>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <form action="{{ route('produk.index') }}" method="GET">
                <select name="kategori" class="form-select" onchange="this.form.submit()" style="max-width: 250px; background-color: #1b2838; color: #c7d5e0; border: 1px solid #66c0f4;">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

    </form>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('produk.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari game seru..." value="{{ request('search') }}">
            <button class="btn btn-search" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>

    @can('create', App\Models\Produk::class)
        <div class="mb-4">
            <a href="{{ route('produk.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus me-1"></i> Tambah Produk
            </a>
        </div>
    @endcan

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($produks as $produk)
            <div class="col">
                <div class="card h-100">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                    @else
                        <div class="card-img-top bg-dark d-flex align-items-center justify-content-center">
                            <span class="text-muted">Tidak Ada Gambar</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $produk->nama }}</h6>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($produk->deskripsi, 120) }}</p>
                        <p class="card-text"><strong>Kategori:</strong> {{ $produk->kategori->nama ?? '-' }}</p>
                        <p class="price-tag">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <div class="d-flex gap-2 mt-2">
                            <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-detail btn-game w-50">Detail</a>
                            <button class="btn btn-beli btn-game w-50" data-id="{{ $produk->id }}">
                                <i class="fa fa-cart-plus me-1"></i> Beli
                            </button>
                        </div>
                        @if($produk->itch_io_link)
                            <a href="{{ $produk->itch_io_link }}" target="_blank" class="btn btn-success btn-game btn-sm w-100 mt-2">
                                <i class="fa fa-gamepad me-1"></i> Mainkan di Itch.io
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($produks->isEmpty())
        <div class="text-center text-muted mt-4">
            <p>Belum ada produk yang tersedia.</p>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-beli').forEach(button => {
        button.addEventListener('click', () => {
            const produkId = button.getAttribute('data-id');

            fetch("{{ route('keranjang.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id: produkId, quantity: 1 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-count').innerText = data.totalItems;
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk ditambahkan ke keranjang.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menambahkan ke keranjang.',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });
    });
});
</script>
@endsection
