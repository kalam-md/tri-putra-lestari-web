@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Edit Model Baju</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('model-baju.update', $model_baju->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_model">Nama Model</label>
                                        <input type="text" class="form-control @error('nama_model') is-invalid @enderror" 
                                               id="nama_model" name="nama_model" value="{{ old('nama_model', $model_baju->nama_model) }}">
                                        @error('nama_model')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="harga">Harga (Rp)</label>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                               id="harga" name="harga" value="{{ old('harga', $model_baju->harga) }}" step="0.01">
                                        @error('harga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="stok">Stok</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                               id="stok" name="stok" value="{{ old('stok', $model_baju->stok) }}">
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="ukuran_id">Ukuran</label>
                                        <select class="form-select @error('ukuran_id') is-invalid @enderror" id="ukuran_id" name="ukuran_id">
                                            <option value="">-- Pilih Ukuran --</option>
                                            @foreach($ukurans as $ukuran)
                                                <option value="{{ $ukuran->id }}" {{ old('ukuran_id', $model_baju->ukuran_id) == $ukuran->id ? 'selected' : '' }}>
                                                    {{ $ukuran->ukuran_baju }} (P.Badan: {{ $ukuran->panjang_badan }}cm, 
                                                    P.Tangan: {{ $ukuran->panjang_tangan }}cm, 
                                                    L.Dada: {{ $ukuran->lebar_dada }}cm)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ukuran_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="bahan_id">Bahan</label>
                                        <select class="form-select @error('bahan_id') is-invalid @enderror" id="bahan_id" name="bahan_id">
                                            <option value="">-- Pilih Bahan --</option>
                                            @foreach($bahan_bajus as $bahan)
                                                <option value="{{ $bahan->id }}" {{ old('bahan_id', $model_baju->bahan_id) == $bahan->id ? 'selected' : '' }}>
                                                    {{ $bahan->nama_bahan }} ({{ $bahan->motif_bahan }}) - Stok: {{ $bahan->stok }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bahan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                                  id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $model_baju->keterangan) }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Menampilkan Gambar Lama -->
                                    <div class="form-group mb-3">
                                        <label>Gambar Lama</label>
                                        <div class="d-flex flex-wrap">
                                            @foreach(json_decode($model_baju->gambar, true) as $gambar)
                                                <div class="m-2">
                                                    <img src="{{ asset('/model_baju/' . $gambar) }}" class="border rounded" 
                                                         style="max-width: 120px; max-height: 120px; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Input untuk Upload Gambar Baru -->
                                    <div class="form-group mb-3">
                                        <label for="gambar">Gambar Baru (Optional, Multiple)</label>
                                        <input type="file" class="form-control @error('gambar.*') is-invalid @enderror" 
                                               id="gambar" name="gambar[]" accept="image/*" multiple onchange="previewImages(event)">
                                        <div class="form-text">Upload gambar baru jika ingin mengganti yang lama. Maks 2MB per gambar.</div>
                                        @error('gambar.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Preview Gambar Baru -->
                                    <div class="image-previews mt-3 d-flex flex-wrap" id="image-previews">
                                        <!-- Preview gambar akan muncul di sini -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('model-baju.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript untuk Preview Gambar -->
<script>
    function previewImages(event) {
        const input = event.target;
        const previewContainer = document.getElementById('image-previews');
        
        // Hapus preview sebelumnya
        previewContainer.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'm-2';
                    
                    const image = document.createElement('img');
                    image.src = e.target.result;
                    image.alt = 'Preview Gambar';
                    image.style.maxWidth = '120px';
                    image.style.maxHeight = '120px';
                    image.style.objectFit = 'cover';
                    image.className = 'border rounded';
                    
                    previewDiv.appendChild(image);
                    previewContainer.appendChild(previewDiv);
                }
                
                reader.readAsDataURL(input.files[i]);
            }
        }
    }
</script>
@endsection
