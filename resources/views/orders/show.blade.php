@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Detail Pesanan #{{ $order->kode_order }}</h3>
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
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Informasi Pesanan</h4>
                        <span class="badge 
                            @if($order->status == 'menunggu_pembayaran') bg-warning
                            @elseif($order->status == 'diproses') bg-info
                            @elseif($order->status == 'dikirim') bg-primary
                            @elseif($order->status == 'selesai') bg-success
                            @else bg-danger
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($order->status)) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informasi Pengiriman</h5>
                            <p>
                                <strong>Nama Penerima:</strong> {{ $order->nama_penerima }}<br>
                                <strong>No. Telepon:</strong> {{ $order->no_telepon }}<br>
                                <strong>Alamat:</strong> {{ $order->alamat }}<br>
                                <strong>Kode Pos:</strong> {{ $order->kode_pos }}<br>
                                <strong>Catatan:</strong> {{ $order->catatan ?? '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Informasi Pembayaran</h5>
                            <p>
                                <strong>Metode Pembayaran:</strong> {{ str_replace('_', ' ', ucfirst($order->metode_pembayaran)) }}<br>
                                <strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}<br>
                                <strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}<br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4>Item Pesanan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Ukuran</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $gambar = json_decode($item->modelBaju->gambar);
                                            @endphp
                                            
                                            @if($gambar && count($gambar) > 0)
                                                <img src="{{ asset('storage/model_baju/' . $gambar[0]) }}" alt="{{ $item->modelBaju->nama_model }}" width="50" height="50" style="object-fit: cover;" class="me-3">
                                            @else
                                                <img src="{{ asset('images/default-image.webp') }}" alt="Default" width="50" height="50" style="object-fit: cover;" class="me-3">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $item->modelBaju->nama_model }}</h6>
                                                <small class="text-muted">{{ $item->modelBaju->bahanBaju->nama_bahan ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->ukuran->ukuran_baju }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total</strong></td>
                                    <td><strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($order->status == 'menunggu_pembayaran' && $order->metode_pembayaran != 'cod')
            <div class="text-center mt-4">
                <a href="{{ $order->payment_url ?? route('orders.payment', $order) }}" class="btn btn-primary btn-lg">
                    Lanjutkan Pembayaran
                </a>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection