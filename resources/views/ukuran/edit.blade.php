@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Edit Ukuran Baju</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('ukuran.update', $ukuran) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="ukuran_baju">Ukuran Baju</label>
                                <input type="text" class="form-control @error('ukuran_baju') is-invalid @enderror" 
                                       id="ukuran_baju" name="ukuran_baju" value="{{ old('ukuran_baju', $ukuran->ukuran_baju) }}">
                                @error('ukuran_baju')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="panjang_badan">Panjang Badan (CM)</label>
                                <input type="number" class="form-control @error('panjang_badan') is-invalid @enderror" 
                                       id="panjang_badan" name="panjang_badan" value="{{ old('panjang_badan', $ukuran->panjang_badan) }}">
                                @error('panjang_badan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="panjang_tangan">Panjang Tangan (CM)</label>
                                <input type="number" class="form-control @error('panjang_tangan') is-invalid @enderror" 
                                       id="panjang_tangan" name="panjang_tangan" value="{{ old('panjang_tangan', $ukuran->panjang_tangan) }}">
                                @error('panjang_tangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lebar_dada">Lebar Dada (CM)</label>
                                <input type="number" class="form-control @error('lebar_dada') is-invalid @enderror" 
                                       id="lebar_dada" name="lebar_dada" value="{{ old('lebar_dada', $ukuran->lebar_dada) }}">
                                @error('lebar_dada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                            <a href="{{ route('ukuran.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection