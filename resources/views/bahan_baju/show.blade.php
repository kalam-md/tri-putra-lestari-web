@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Detail Bahan Baju</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Bahan:</label>
                                    <p class="form-control-static">{{ $bahan_baju->nama_bahan }}</p>
                                </div>

                                <div class="form-group">
                                    <label>Motif Bahan:</label>
                                    <p class="form-control-static">{{ $bahan_baju->motif_bahan }}</p>
                                </div>

                                <div class="form-group">
                                    <label>Stok:</label>
                                    <p class="form-control-static">{{ $bahan_baju->stok }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label>Gambar:</label>
                                <div>
                                    <img src="{{ $bahan_baju->gambar ? asset('storage/bahan_baju/' . $bahan_baju->gambar) : asset('images/default-image.webp') }}" 
                                         alt="Gambar Bahan Baju" 
                                         style="max-width: 300px; max-height: 300px; object-fit: cover;" class="img-thumbnail">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <a href="{{ route('bahan-baju.index') }}" class="btn btn-secondary">Kembali</a>
                            <a href="{{ route('bahan-baju.edit', $bahan_baju->id) }}" class="btn btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection