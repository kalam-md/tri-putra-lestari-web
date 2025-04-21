@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Edit Profil</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                               id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}">
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                               id="username" name="username" value="{{ old('username', auth()->user()->username) }}">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="photo">Foto Profil</label>
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                               id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div class="mt-3 text-center">
                                            <img id="image-preview" 
                                                 src="{{ auth()->user()->photo ? asset('storage/profile/' . auth()->user()->photo) : asset('images/default-image.webp') }}" 
                                                 alt="Preview Foto" 
                                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Profil</button>
                                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Batal</a>
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
            preview.src = "{{ auth()->user()->photo ? asset('storage/profile/' . auth()->user()->photo) : asset('images/default-image.webp') }}";
        }
    }
</script>
