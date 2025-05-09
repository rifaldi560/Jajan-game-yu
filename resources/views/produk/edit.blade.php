@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Produk</h4>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Kode Produk --}}
                        <div class="mb-3">
                            <label for="kode_produk" class="form-label">Kode Produk</label>
                            <input type="text" name="kode_produk" class="form-control" value="{{ $produk->kode_produk }}" required>
                        </div>

                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}" required>
                        </div>

                        {{-- Harga Produk --}}
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required min="0">
                        </div>

                        {{-- Kategori Produk --}}
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Link Itch.io --}}
                        <div class="mb-3">
                            <label for="itch_io_link" class="form-label">Link Itch.io</label>
                            <input type="url" name="itch_io_link" class="form-control" value="{{ $produk->itch_io_link }}" placeholder="Masukkan link game di Itch.io" required>
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label><br>

                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" width="100" class="mb-2" style="border-radius: 8px;">
                            @else
                                <p class="text-muted">Belum ada gambar</p>
                            @endif

                            <input type="file" name="gambar" class="form-control mt-2">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                        </div>

                        {{-- Deskripsi Produk --}}
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.home') }}" class="btn btn-secondary">Kembali</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
