@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-2 text-white">📂 Daftar Kategori Game</h4>
            <a href="{{ route('kategori.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Tambah Kategori Game
            </a>
        </div>
        <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-box"></i> Tambah Produk Game
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm" style="background-color: #1B2538; color: #ffffff;">
        <div class="card-body">
            <table class="table table-bordered table-dark table-striped">
                <thead style="background-color: #2C3E50; color: #ffffff;">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori Game</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="kategori-name">{{ $kategori->nama }}</td>
                            <td>
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-white">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert & Script AJAX -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let kategoriName = this.closest('tr').querySelector('.kategori-name').textContent.trim();

            Swal.fire({
                title: 'Yakin ingin menghapus kategori "' + kategoriName + '"?',
                text: "Kategori ini akan dihapus dan tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection
