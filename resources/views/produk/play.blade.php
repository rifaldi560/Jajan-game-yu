@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card bg-dark text-white shadow-lg">
        <div class="card-body">
            <h3 class="card-title">Mainkan Game: {{ $produk->nama }}</h3>
            <hr class="bg-light">

            <div class="ratio ratio-16x9" style="height: 600px;">
                <iframe
                    src="{{ $url }}"
                    frameborder="0"
                    allowfullscreen
                    style="width:100%; height:100%; border-radius: 10px; overflow:hidden;">
                </iframe>
            </div>

            <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-secondary mt-3">
                Kembali ke Detail Produk
            </a>
        </div>
    </div>
</div>
@endsection
