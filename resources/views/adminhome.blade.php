@extends('layouts.app')
@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Dashboard Produk Game</h2>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('transactions.history') }}" class="btn btn-secondary">
                <i class="fa fa-history"></i> Riwayat Transaksi User
            </a>
            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Produk Game
            </a>
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-primary">
                <i class="fa fa-list"></i> Lihat Kategori Game
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Produk List -->
    @if($produks->isEmpty())
        <div class="text-center text-muted mt-5">
            <h5>Belum ada produk yang tersedia.</h5>
        </div>
    @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($produks as $produk)
        <div class="col">
            <div class="card h-100 shadow-sm border-0">

                @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="card-img-top" style="height: 220px; object-fit: cover;">
            @else
                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 220px;">
                    <span class="text-muted">Tidak Ada Gambar</span>
                </div>
            @endif


                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">{{ $produk->nama }}</h5>
                    <p class="text-muted small mb-1">{{ $produk->kategori->nama ?? 'Tanpa Kategori' }}</p>
                    <p class="card-text small text-secondary mb-2">{{ Str::limit($produk->deskripsi, 50) }}</p>
                    <h6 class="fw-bold text-primary mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h6>

                    <div class="mt-auto">
                        <div class="d-grid gap-2">
                            <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit Produk</a>
                            <button onclick="confirmDelete({{ $produk->id }})" class="btn btn-danger btn-sm">Hapus Produk</button>
                        </div>
                    </div>

                    <form id="delete-form-{{ $produk->id }}" action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

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
@endsection
