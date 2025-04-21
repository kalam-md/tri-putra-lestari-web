@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Tambah Model Baju</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('model-baju.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_model">Nama Model</label>
                                        <input type="text" class="form-control @error('nama_model') is-invalid @enderror" 
                                               id="nama_model" name="nama_model" value="{{ old('nama_model') }}">
                                        @error('nama_model')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="harga">Harga (Rp)</label>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                               id="harga" name="harga" value="{{ old('harga') }}" step="0.01">
                                        @error('harga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="bahan_id">Bahan</label>
                                        <select class="form-select @error('bahan_id') is-invalid @enderror" id="bahan_id" name="bahan_id">
                                            <option value="">-- Pilih Bahan --</option>
                                            @foreach($bahan_bajus as $bahan)
                                                <option value="{{ $bahan->id }}" {{ old('bahan_id') == $bahan->id ? 'selected' : '' }}>
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
                                                  id="keterangan" name="keterangan" rows="4">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="gambar">Gambar (Multiple)</label>
                                        <input type="file" class="form-control @error('gambar.*') is-invalid @enderror" 
                                               id="gambar" name="gambar[]" accept="image/*" multiple onchange="previewImages(event)">
                                        <div class="form-text">Anda dapat memilih beberapa gambar sekaligus. Maks 2MB per gambar.</div>
                                        @error('gambar.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="image-previews mt-3 d-flex flex-wrap" id="image-previews">
                                        <!-- Preview gambar akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Pilih Ukuran dan Stok</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="ukuran-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="50px">Pilih</th>
                                                            <th>Ukuran</th>
                                                            <th>Panjang Badan</th>
                                                            <th>Panjang Tangan</th>
                                                            <th>Lebar Dada</th>
                                                            <th width="150px">Stok</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($ukurans as $ukuran)
                                                        <tr>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input ukuran-checkbox" type="checkbox" 
                                                                           name="ukuran_id[]" value="{{ $ukuran->id }}" 
                                                                           id="ukuran-{{ $ukuran->id }}"
                                                                           {{ in_array($ukuran->id, old('ukuran_id', [])) ? 'checked' : '' }}
                                                                           onchange="toggleUkuranStok(this)">
                                                                </div>
                                                            </td>
                                                            <td>{{ $ukuran->ukuran_baju }}</td>
                                                            <td>{{ $ukuran->panjang_badan }} cm</td>
                                                            <td>{{ $ukuran->panjang_tangan }} cm</td>
                                                            <td>{{ $ukuran->lebar_dada }} cm</td>
                                                            <td>
                                                                <input type="number" class="form-control stok-input" 
                                                                       name="stok[{{ $loop->index }}]" 
                                                                       value="{{ old('stok.' . $loop->index, 0) }}"
                                                                       min="0" 
                                                                       {{ !in_array($ukuran->id, old('ukuran_id', [])) ? 'disabled' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="5" class="text-end">Total Stok:</th>
                                                            <th><span id="total-stok">0</span></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            @error('ukuran_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                            @error('stok.*')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('model-baju.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function previewImages(event) {
        const input = event.target;
        const previewContainer = document.getElementById('image-previews');
        
        // Clear previous previews
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
                    image.style.maxWidth = '150px';
                    image.style.maxHeight = '150px';
                    image.style.objectFit = 'cover';
                    image.className = 'border rounded';
                    
                    previewDiv.appendChild(image);
                    previewContainer.appendChild(previewDiv);
                }
                
                reader.readAsDataURL(input.files[i]);
            }
        }
    }
    
    function toggleUkuranStok(checkbox) {
        const row = checkbox.closest('tr');
        const stokInput = row.querySelector('.stok-input');
        
        stokInput.disabled = !checkbox.checked;
        if (!checkbox.checked) {
            stokInput.value = 0;
        }
        
        updateTotalStok();
    }
    
    function updateTotalStok() {
        let total = 0;
        const stokInputs = document.querySelectorAll('.stok-input:not([disabled])');
        
        stokInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        
        document.getElementById('total-stok').textContent = total;
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to all stok inputs
        const stokInputs = document.querySelectorAll('.stok-input');
        stokInputs.forEach(input => {
            input.addEventListener('input', updateTotalStok);
        });
        
        // Calculate initial total
        updateTotalStok();
    });
</script>
@endsection