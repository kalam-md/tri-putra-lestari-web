@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Pembayaran Pesanan #{{ $order->kode_order }}</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Instruksi Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5 class="alert-heading">Total Pembayaran: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
                        <p>Silakan selesaikan pembayaran Anda untuk melanjutkan proses pesanan.</p>
                    </div>

                    <div id="snap-container" class="text-center my-4">
                        @if($order->payment_url)
                            <a href="{{ $order->payment_url }}" class="btn btn-primary btn-lg">
                                Lanjutkan ke Halaman Pembayaran
                            </a>
                        @else
                            <div class="alert alert-warning">
                                Link pembayaran tidak tersedia. Silakan hubungi admin.
                            </div>
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                            Kembali ke Detail Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection