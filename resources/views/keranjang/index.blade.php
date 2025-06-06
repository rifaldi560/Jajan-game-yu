@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #1b2838;
        color: #fff; /* Ensures text is readable on dark background */
    }

    .card-product {
        display: flex;
        align-items: center;
        background: #2a2f38;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .card-product img {
        width: 350px;
        height: 350px;
        object-fit: cover;
        border-radius: 0;
        background: #f0f0f0;
    }

    .card-body {
        flex-grow: 1;
        padding: 15px;
    }

    .card-body h5 {
        margin-bottom: 8px;
        font-size: 1.25rem;
        font-weight: bold;
        color: #ffffff;
    }

    .card-body p {
        margin: 3px 0;
        color: #777;
    }

    .quantity-input {
        width: 70px;
        height: 40px;
        text-align: center;
        font-size: 1rem;
        margin-top: 8px;
        margin-bottom: 8px;
    }

    .total-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2a9d8f;
        margin-top: 5px;
    }

    .actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        gap: 10px;
    }

    .remove-item-btn {
        font-size: 0.85rem;
        padding: 6px 12px;
    }

    /* Tombol checkout, kosongkan keranjang */
    .clear-cart-btn, .checkout-btn {
        font-size: 1rem;
        padding: 10px 16px;
        border-radius: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-product {
            flex-direction: column;
            align-items: flex-start;
        }
        .card-product img {
            width: 100%;
            height: auto;
        }
        .actions {
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }
    }
</style>



<div class="container">
    <h2 class="mb-4">Keranjang Belanja Kamu</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(!empty($cart))
        <div class="row">
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php $total += $item['harga'] * $item['quantity']; @endphp
                <div class="col-12 mb-3">
                    <div class="card-product">
                        @if(isset($item['gambar']) && $item['gambar'])
                        <img src="{{ asset('storage/' . $item['gambar']) }}" class="card-img-top" alt="{{ $item['nama'] }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">Tidak Ada Gambar</span>
                        </div>
                    @endif


                    <div class="card-body">
                        <h5>{{ $item['nama'] }}</h5>
                        <p>Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                        <input type="number" class="form-control quantity-input" data-id="{{ $id }}" value="{{ $item['quantity'] }}" min="1">
                        <p class="total-price">Total: Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</p>
                    </div>
                    <div class="actions">
                        <button class="btn btn-danger remove-item-btn" data-id="{{ $id }}">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
                </div>
            @endforeach
        </div>

        <h4 class="mt-3">Total Belanja: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></h4>

        <div class="d-flex gap-2 flex-wrap mt-2">
            <button class="btn btn-warning clear-cart-btn">
                <i class="fa fa-trash"></i> Kosongkan Keranjang
            </button>
            <a href="{{ route('keranjang.checkout') }}" class="btn btn-success checkout-btn" id="btn-checkout">
                <i class="fa fa-credit-card"></i> Checkout
            </a>
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fa fa-home"></i> Kembali ke Home
            </a>
        </div>
    @else
        <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 70vh;">
            <h3 class="text-muted mb-4" style="color: #fff !important;">🛒 Keranjang belanja kamu kosong</h3>
            <a href="{{ route('home') }}" class="btn btn-lg btn-primary text-white" style="background-color: #007bff;">
                <i class="fa fa-home me-2"></i> Kembali ke Home
            </a>
        </div>
    @endif
</div>

<!-- SweetAlert & Script AJAX -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const totalBelanja = @json($total ?? 0);
    document.addEventListener('DOMContentLoaded', function() {
        // Update jumlah produk dalam keranjang
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                let id = this.getAttribute('data-id');
                let quantity = this.value;

                fetch("{{ route('keranjang.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ id: id, quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Gagal memperbarui jumlah produk.");
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Konfirmasi sebelum Checkout
        document.getElementById('btn-checkout')?.addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Lanjutkan ke Checkout?",
                html: "Total belanja Anda: <strong>Rp " + totalBelanja.toLocaleString('id-ID') + "</strong><br>Pastikan semua produk sudah benar.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Checkout",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = this.href;
                }
            });
        });

        // Hapus item dari keranjang dengan SweetAlert
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');

                Swal.fire({
                    title: "Yakin ingin menghapus?",
                    text: "Produk ini akan dihapus dari keranjang.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('keranjang.remove') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ id: id })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Dihapus!", "Produk telah dihapus.", "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Gagal!", "Produk gagal dihapus.", "error");
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });
        });

        // Kosongkan seluruh keranjang dengan SweetAlert
        document.querySelector('.clear-cart-btn')?.addEventListener('click', function() {
            Swal.fire({
                title: "Yakin ingin mengosongkan keranjang?",
                text: "Semua produk akan dihapus.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, kosongkan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('keranjang.clear') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Dikosongkan!", "Keranjang telah dikosongkan.", "success").then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Gagal!", "Gagal mengosongkan keranjang.", "error");
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });

        // Disabled tombol Checkout jika keranjang kosong
        let checkoutButton = document.querySelector('.checkout-btn');
        if (!document.querySelector('.quantity-input')) {
            checkoutButton.setAttribute('disabled', 'disabled');
        }
    });
</script>
@endsection
