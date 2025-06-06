@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #171a21;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #c7d5e0;
    }
    .card {
        background-color: #2c3038;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }
    .img-fluid {
        max-width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .card-header h4 {
        font-size: 2rem;
        font-weight: bold;
        color: #f1f1f1;
        margin-bottom: 0;
    }
    h5 {
        font-size: 1.6rem;
        font-weight: bold;
        margin-bottom: 15px;
        color: #f1f1f1;
    }
    p {
        font-size: 1.2rem;
        line-height: 1.5;
        color: #b0bec5;
    }
    .btn {
        font-weight: 600;
        font-size: 1.2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 12px 20px;
        text-align: center;
        display: inline-block;
        width: auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .btn:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    .btn-beli {
        background-color: #007bff;
        color: white;
    }
    .btn-beli:hover {
        background-color: #0056b3;
    }
    .btn-detail {
        background-color: #28a745;
        color: white;
    }
    .btn-detail:hover {
        background-color: #218838;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    .btn-sm {
        padding: 3px 12px;
        font-size: 0.85rem;
    }
    .btn-danger {
        background-color: #dc3545;
        color: white;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    .btn-warning {
        background-color: #ffc107;
        color: black;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .btn-success {
        background-color: #28a745;
        color: white;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    @media (max-width: 767px) {
        .btn {
            width: 100%;
            font-size: 1.2rem;
            padding: 14px 18px;
        }
        .img-fluid {
            max-height: 400px;
        }
        h5 {
            font-size: 1.4rem;
        }
        p {
            font-size: 1.1rem;
        }
    }
    .d-flex.gap-2 {
        gap: 10px;
    }
    .card-header {
        background-color: #23272b;
        border-radius: 10px 10px 0 0;
        padding: 15px;
    }
    .mt-4 {
        margin-top: 20px;
    }
</style>

<div class="container">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Detail Produk</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="img-fluid">
                    @else
                        <div class="bg-light text-center p-4">
                            <span class="text-muted">Tidak Ada Gambar</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h5>{{ $produk->nama }}</h5>
                    <p><strong>Kategori:</strong> {{ $produk->kategori->nama ?? 'Tanpa Kategori' }}</p>
                    <p><strong>Deskripsi:</strong> {{ $produk->deskripsi }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    @php
                        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
                    @endphp

                    {{-- ADMIN: Edit & Hapus --}}
                    @can('update', $produk)
                        <div class="d-flex gap-2 mb-3">
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger" onclick="confirmDelete({{ $produk->id }})">Hapus</button>
                            <form id="delete-form-{{ $produk->id }}" action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endcan

                    {{-- USER: Beli, Itch.io, Download & Mainkan --}}
                    @cannot('update', $produk)
                  <div class="d-flex gap-2 flex-wrap mt-2">

                            {{-- Tombol Beli --}}
                            <button class="btn btn-beli btn-game" data-id="{{ $produk->id }}">
                                <i class="fa fa-cart-plus me-1"></i> Beli
                            </button>

                            {{-- Tombol Itch.io --}}
                            @if($produk->itch_io_link)
                                <a href="{{ $produk->itch_io_link }}" target="_blank" class="btn btn-success">
                                    <i class="fa fa-gamepad me-1"></i> Mainkan di Itch.io
                                </a>
                            @endif

                            {{-- Tombol Download Game, jika file tersedia --}}
                            @if($produk->file_game)
                                <a href="{{ route('storage.downloadGame', $produk->id) }}" class="btn btn-primary">
                                    <i class="fa fa-download me-1"></i> Download Game
                                </a>
                            @endif

@if($produk->file_game)
    <a href="{{ route('produk.play', $produk->id) }}" class="btn btn-primary">Mainkan Game</a>
@endif
                        </div>
                    @endcannot

                    <div class="mt-4">
                        @can('update', $produk)
                            <a href="{{ route('admin.home') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali ke Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali ke Beranda
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Hapus Produk?",
            text: "Produk yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

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
                        if (document.getElementById('cart-count')) {
                            document.getElementById('cart-count').innerText = data.totalItems;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Produk ditambahkan ke keranjang!',
                            text: 'Anda akan diarahkan ke halaman transaksi.',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "{{ route('keranjang.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Produk tidak dapat ditambahkan ke keranjang.'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menambahkan ke keranjang.'
                    });
                });
            });
        });
    });
</script>
@endsection
