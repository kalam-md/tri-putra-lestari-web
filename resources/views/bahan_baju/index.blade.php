@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Daftar Bahan Baju</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('bahan-baju.create') }}" class="btn btn-primary me-2">Tambah Bahan Baju</a>
                    </div>
                    <form action="{{ route('bahan-baju.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari bahan baju..." 
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">
                            <i data-feather="search"></i>
                        </button>
                    </form>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama Bahan</th>
                                        <th>Motif Bahan</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bahan_bajus as $bahan)
                                    <tr>
                                        <td>
                                            <img src="{{ $bahan->gambar_url }}" 
                                                 alt="{{ $bahan->nama_bahan }}" 
                                                 style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </td>
                                        <td>{{ $bahan->nama_bahan }}</td>
                                        <td>{{ $bahan->motif_bahan }}</td>
                                        <td>{{ $bahan->stok }}</td> 
                                        <td>
                                            <a href="{{ route('bahan-baju.show', $bahan) }}" class="btn btn-sm btn-info">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <a href="{{ route('bahan-baju.edit', $bahan) }}" class="btn btn-sm btn-warning">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <form action="{{ route('bahan-baju.destroy', $bahan) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            @if(request('search'))
                                                Tidak ada bahan baju yang cocok dengan "{{ request('search') }}"
                                            @else
                                                Belum ada data bahan baju
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Links --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $bahan_bajus->firstItem() }} - {{ $bahan_bajus->lastItem() }} 
                                dari {{ $bahan_bajus->total() }} data
                            </div>
                            <div>
                                {{ $bahan_bajus->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection