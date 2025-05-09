@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Riwayat Transaksi</h2>

    @if($transactions->isEmpty())
        <p class="text-muted">Belum ada transaksi.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
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
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Change Status
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item text-white" type="submit" name="status" value="success" style="background-color: #28a745;">
                                                    Mark as Success
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-white" type="submit" name="status" value="cancelled" style="background-color: #dc3545;">
                                                    Mark as Cancelled
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @elseif($transaction->status === 'success')
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" style="background-color: #28a745;">
                                            Success
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item text-white" type="submit" name="status" value="cancelled" style="background-color: #dc3545;">
                                                    Mark as Cancelled
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @elseif($transaction->status === 'cancelled')
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" style="background-color: #dc3545;">
                                            Cancelled
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
