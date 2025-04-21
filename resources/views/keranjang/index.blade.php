@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Keranjang Pesanan</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Daftar Item Keranjang</h4>
                            <a href="/" class="btn btn-primary">Lanjut Belanja</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>Gambar</th>
                                                <th>Model Baju</th>
                                                <th>Ukuran</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($keranjangItems as $item)
                                            <tr>
                                                <td>
                                                    @php
                                                        $gambar = json_decode($item->modelBaju->gambar);
                                                    @endphp
                                                    
                                                    @if($gambar && count($gambar) > 0)
                                                        <img src="{{ asset('model_baju/' . $gambar[0]) }}" alt="{{ $item->modelBaju->nama_model }}" width="80" height="80" style="object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/default-image.webp') }}" alt="Default" width="80" height="80" style="object-fit: cover;">
                                                    @endif
                                                </td>
                                                <td class="text-bold-500">{{ $item->modelBaju->nama_model }}</td>
                                                <td>{{ $item->ukuran->ukuran_baju }}</td>
                                                <td>Rp {{ number_format($item->modelBaju->harga, 0, ',', '.') }}</td>
                                                <td>
                                                    <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" class="form-control" style="width: 80px;">
                                                        <button type="submit" class="btn btn-sm btn-info ms-2">
                                                            <i data-feather="refresh-cw"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>Rp {{ number_format($item->jumlah * $item->modelBaju->harga, 0, ',', '.') }}</td>
                                                <td>
                                                    <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    Keranjang belanja Anda kosong
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end fw-bold">Total</td>
                                                <td class="fw-bold">Rp {{ number_format($totalHarga ?? 0, 0, ',', '.') }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                @if(isset($keranjangItems) && count($keranjangItems) > 0)
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('checkout.index') }}" class="btn btn-success">
                                        Lanjut ke Checkout
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection