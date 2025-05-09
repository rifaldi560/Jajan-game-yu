@extends('layouts.app')

@section('content')
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

                    <!-- Tombol Edit dan Hapus hanya untuk admin -->
                    @can('update', $produk)
                        <div class="d-flex gap-2">
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger" onclick="confirmDelete({{ $produk->id }})">Hapus</button>
                            <form id="delete-form-{{ $produk->id }}" action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endcan

                    <!-- Tombol Kembali -->
                    <div class="mt-4">
                        @can('viewAny', App\Models\Produk::class) <!-- Admin -->
                            <a href="{{ route('admin.home') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali ke Dashboard Admin
                            </a>
                        @else <!-- User biasa -->
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
@endsection
