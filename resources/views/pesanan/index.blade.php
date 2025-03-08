@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Daftar Pesanan</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            {{-- <div>
                                <a href="{{ route('ukuran.create') }}" class="btn btn-primary me-2">Tambah Ukuran</a>
                            </div> --}}
                            <form action="{{ route('ukuran.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari ukuran baju..." 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i data-feather="search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    {{-- <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>Ukuran Baju</th>
                                                <th>Panjang Badan (CM)</th>
                                                <th>Panjang Tangan (CM)</th>
                                                <th>Lebar Dada (CM)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($ukurans as $ukuran)
                                            <tr>
                                                <td class="text-bold-500">{{ $ukuran->ukuran_baju }}</td>
                                                <td>{{ $ukuran->panjang_badan }}</td>
                                                <td>{{ $ukuran->panjang_tangan }}</td>
                                                <td>{{ $ukuran->lebar_dada }}</td>
                                                <td>
                                                    <a href="{{ route('ukuran.edit', $ukuran) }}" class="btn btn-sm btn-warning">
                                                        <i data-feather="edit"></i>
                                                    </a>
                                                    <form action="{{ route('ukuran.destroy', $ukuran) }}" method="POST" class="d-inline">
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
                                                        Tidak ada ukuran yang cocok dengan "{{ request('search') }}"
                                                    @else
                                                        Belum ada data ukuran
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table> --}}
                                </div>

                                {{-- Pagination Links --}}
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    {{-- <div>
                                        Menampilkan {{ $ukurans->firstItem() }} - {{ $ukurans->lastItem() }} 
                                        dari {{ $ukurans->total() }} data
                                    </div>
                                    <div>
                                        {{ $ukurans->appends(request()->query())->links() }}
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection