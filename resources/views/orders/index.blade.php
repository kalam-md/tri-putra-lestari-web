@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Daftar Pesanan</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Order</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->kode_order }}</td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status == 'menunggu_pembayaran') bg-warning
                                            @elseif($order->status == 'diproses') bg-info
                                            @elseif($order->status == 'dikirim') bg-primary
                                            @elseif($order->status == 'selesai') bg-success
                                            @else bg-danger
                                            @endif">
                                            {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pesanan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection