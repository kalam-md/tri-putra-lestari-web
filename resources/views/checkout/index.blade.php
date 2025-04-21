@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Checkout</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Customer Information -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Pengiriman</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="nama_penerima">Nama Penerima</label>
                                    <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" 
                                           id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima', auth()->user()->name) }}" required>
                                    @error('nama_penerima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="no_telepon">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" 
                                           id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="alamat">Alamat Lengkap</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="kode_pos">Kode Pos</label>
                                    <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" 
                                           id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" required>
                                    @error('kode_pos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="catatan">Catatan (Opsional)</label>
                                    <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                              id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h4>Metode Pembayaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="metode_pembayaran" 
                                           id="transfer_bank" value="transfer_bank" {{ old('metode_pembayaran') == 'transfer_bank' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="transfer_bank">
                                        Transfer Bank
                                    </label>
                                    <div class="text-muted small">
                                        Pembayaran melalui transfer bank. Instruksi pembayaran akan dikirimkan setelah checkout.
                                    </div>
                                </div>

                                {{-- <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="metode_pembayaran" 
                                           id="cod" value="cod" {{ old('metode_pembayaran') == 'cod' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cod">
                                        Cash on Delivery (COD)
                                    </label>
                                    <div class="text-muted small">
                                        Bayar saat barang diterima.
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="metode_pembayaran" 
                                           id="e-wallet" value="e-wallet" {{ old('metode_pembayaran') == 'e-wallet' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="e-wallet">
                                        E-Wallet (DANA, OVO, GoPay)
                                    </label>
                                    <div class="text-muted small">
                                        Pembayaran melalui e-wallet. QR Code pembayaran akan diberikan setelah checkout.
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ringkasan Pesanan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            @foreach($keranjangItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            @php
                                                                $gambar = json_decode($item->modelBaju->gambar);
                                                            @endphp
                                                            
                                                            @if($gambar && count($gambar) > 0)
                                                                <img src="{{ asset('model_baju/' . $gambar[0]) }}" alt="{{ $item->modelBaju->nama_model }}" width="50" height="50" style="object-fit: cover;">
                                                            @else
                                                                <img src="{{ asset('images/default-image.webp') }}" alt="Default" width="50" height="50" style="object-fit: cover;">
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="mb-0">{{ $item->modelBaju->nama_model }}</p>
                                                            <small class="text-muted">
                                                                Ukuran: {{ $item->ukuran->ukuran_baju }} | 
                                                                Jumlah: {{ $item->jumlah }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    Rp {{ number_format($item->jumlah * $item->modelBaju->harga, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Biaya Pengiriman</span>
                                    <span>Rp 0</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block w-100">
                                    Buat Pesanan
                                </button>

                                <a href="{{ route('keranjang.index') }}" class="btn btn-outline-secondary btn-block w-100 mt-2">
                                    Kembali ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection