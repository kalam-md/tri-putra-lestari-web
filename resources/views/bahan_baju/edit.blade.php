@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Edit Bahan Baju</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('bahan-baju.update', $bahan_baju->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_bahan">Nama Bahan</label>
                                        <input type="text" class="form-control @error('nama_bahan') is-invalid @enderror" 
                                               id="nama_bahan" name="nama_bahan" value="{{ old('nama_bahan', $bahan_baju->nama_bahan) }}">
                                        @error('nama_bahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="motif_bahan">Motif Bahan</label>
                                        <input type="text" class="form-control @error('motif_bahan') is-invalid @enderror" 
                                               id="motif_bahan" name="motif_bahan" value="{{ old('motif_bahan', $bahan_baju->motif_bahan) }}">
                                        @error('motif_bahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                               id="stok" name="stok" value="{{ old('stok', $bahan_baju->stok) }}">
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gambar">Gambar</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                               id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div class="mt-3 text-center">
                                            <img id="image-preview" 
                                                 src="{{ $bahan_baju->gambar ? asset('storage/bahan_baju/' . $bahan_baju->gambar) : asset('images/default-image.webp') }}" 
                                                 alt="Preview Gambar" 
                                                 style="max-width: 300px; max-height: 300px; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('bahan-baju.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "{{ $bahan_baju->gambar ? asset('storage/bahan_baju/' . $bahan_baju->gambar) : asset('images/default-image.webp') }}";
        }
    }
</script>