@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #1b2838;
        color: #fff;
    }

    h2 {
        color: #fff;
    }

    .table {
        background-color: #2a3b4c;
        color: #fff;
    }

    .table th,
    .table td {
        vertical-align: middle;
        border-color: #3c4f63;
    }

    .table thead th {
        background-color: #16222e;
        color: #fff;
    }

    .dropdown-menu {
        background-color: #2a3b4c;
        border: none;
    }

    .dropdown-item {
        color: #fff;
    }

    .dropdown-item:hover {
        background-color: #3b5163;
    }

    .text-muted {
        color: #bbb !important;
    }

    .btn-secondary {
        background-color: #495057;
        border-color: #495057;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-home {
        background-color: #0d6efd;
        border: none;
        color: white;
    }

    .btn-home:hover {
        background-color: #0b5ed7;
    }
</style>

<div class="container mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.home') }}" class="btn btn-home btn-lg">
            <i class="bi bi-house-door-fill me-1"></i> Home
        </a>
        <h2 class="mb-0">Riwayat Transaksi</h2>
    </div>
</div>

<div class="container">
    @if($transactions->isEmpty())
        <p class="text-muted">Belum ada transaksi.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Nama User</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name ?? 'Tidak diketahui' }}</td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>Rp{{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('transactions.updateStatus', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @if($transaction->status === 'pending')
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Ubah Status
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item" type="submit" name="status" value="success" style="background-color: #28a745;">
                                                    Tandai Sukses
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" type="submit" name="status" value="cancelled" style="background-color: #dc3545;">
                                                    Batalkan
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @elseif($transaction->status === 'success')
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" style="background-color: #28a745;">
                                            Sukses
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item" type="submit" name="status" value="cancelled" style="background-color: #dc3545;">
                                                    Batalkan
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @elseif($transaction->status === 'cancelled')
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" style="background-color: #dc3545;">
                                            Dibatalkan
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <span class="dropdown-item text-muted">Tidak dapat diubah</span>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
    