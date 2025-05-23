@extends('layouts.main')

@section('content')
<div class="page-heading">
    <h3>Daftar Model Baju</h3>
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
                        <a href="{{ route('model-baju.create') }}" class="btn btn-primary me-2">Tambah Model Baju</a>
                    </div>
                    <form action="{{ route('model-baju.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari model baju..." 
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
                                        <th>Nama Model</th>
                                        <th>Ukuran</th>
                                        <th>Bahan</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($model_bajus as $model)
                                    <tr>
                                        <td>
                                            @php
                                                $gambarArray = json_decode($model->gambar, true);
                                            @endphp
                                            
                                            @if($gambarArray && count($gambarArray) > 0)
                                                <div id="carousel-{{ $model->id }}" class="carousel slide" data-bs-ride="carousel" style="width: 150px; ">
                                                    <div class="carousel-inner">
                                                        @foreach($gambarArray as $index => $gambar)
                                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                <img src="{{ asset('model_baju/'.$gambar) }}" 
                                                                     alt="{{ $model->nama_model }}" 
                                                                     class="d-block w-100" 
                                                                     style="height: 100px; object-fit: cover;">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if(count($gambarArray) > 1)
                                                        <a class="carousel-control-prev" href="#carousel-{{ $model->id }}" role="button" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carousel-{{ $model->id }}" role="button" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-center">No Image</div>
                                            @endif
                                        </td>
                                        <td>{{ $model->nama_model }}</td>
                                        <td>
                                            @if($model->ukurans->count() > 0)
                                                <button class="btn btn-sm btn-outline-primary btn-ukuran" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#ukuranModal"
                                                        data-ukuran-list="{{ json_encode($model->ukurans->map(function($ukuran) {
                                                            return [
                                                                'ukuran' => $ukuran->ukuran_baju,
                                                                'panjang_badan' => $ukuran->panjang_badan,
                                                                'panjang_tangan' => $ukuran->panjang_tangan,
                                                                'lebar_dada' => $ukuran->lebar_dada,
                                                                'stok' => $ukuran->pivot->stok
                                                            ];
                                                        })) }}">
                                                    Lihat Detail Ukuran
                                                </button>
                                            @else
                                                <span class="text-muted">Tidak ada ukuran</span>
                                            @endif
                                        </td>
                                        <td>{{ $model->bahanBaju->nama_bahan }}</td>
                                        <td>Rp {{ number_format($model->harga, 0, ',', '.') }}</td>
                                        <td>{{ $model->stok }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-info btn-detail" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal"
                                                data-title="{{ $model->nama_model }}"
                                                data-bahan="{{ $model->bahanBaju->nama_bahan }}"
                                                data-harga="{{ number_format($model->harga, 0, ',', '.') }}"
                                                data-stok="{{ $model->stok }}"
                                                data-ukuran-list="{{ json_encode($model->ukurans->map(function($ukuran) {
                                                    return [
                                                        'ukuran' => $ukuran->ukuran_baju,
                                                        'panjang_badan' => $ukuran->panjang_badan,
                                                        'panjang_tangan' => $ukuran->panjang_tangan,
                                                        'lebar_dada' => $ukuran->lebar_dada,
                                                        'stok' => $ukuran->pivot->stok
                                                    ];
                                                })) }}"
                                                data-images="{{ json_encode($gambarArray) }}">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <a href="{{ route('model-baju.edit', $model) }}" class="btn btn-sm btn-warning">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <form action="{{ route('model-baju.destroy', $model) }}" method="POST" class="d-inline">
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
                                        <td colspan="7" class="text-center">
                                            @if(request('search'))
                                                Tidak ada model baju yang cocok dengan "{{ request('search') }}"
                                            @else
                                                Belum ada data model baju
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
                                @if($model_bajus->count() > 0)
                                    Menampilkan {{ $model_bajus->firstItem() }} - {{ $model_bajus->lastItem() }} 
                                    dari {{ $model_bajus->total() }} data
                                @endif
                            </div>
                            <div>
                                {{ $model_bajus->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Model Baju</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-content">
                        <!-- Carousel Gambar -->
                        <div id="modal-carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carousel-inner">
                                <!-- Gambar akan dimasukkan lewat JavaScript -->
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#modal-carousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#modal-carousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                        <!-- Detail Produk -->
                        <div class="card-body">
                            <h4 class="card-title" id="modal-title"></h4>
                            <p class="card-text"><strong>Bahan:</strong> <span id="modal-bahan"></span></p>
                            <p class="card-text"><strong>Harga:</strong> Rp <span id="modal-harga"></span></p>
                            <p class="card-text"><strong>Total Stok:</strong> <span id="modal-stok"></span></p>
                            
                            <div class="mt-3">
                                <h5>Ukuran yang Tersedia:</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="modal-ukuran-table">
                                        <thead>
                                            <tr>
                                                <th>Ukuran</th>
                                                <th>Panjang Badan</th>
                                                <th>Panjang Tangan</th>
                                                <th>Lebar Dada</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody id="modal-ukuran-body">
                                            <!-- Data ukuran akan dimasukkan lewat JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Detail Ukuran -->
<div class="modal fade" id="ukuranModal" tabindex="-1" aria-labelledby="ukuranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ukuranModalLabel">Detail Ukuran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ukuran</th>
                                <th>Panjang Badan</th>
                                <th>Panjang Tangan</th>
                                <th>Lebar Dada</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody id="ukuranModalBody">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Menangani modal detail ukuran
        const ukuranButtons = document.querySelectorAll(".btn-ukuran");
        
        ukuranButtons.forEach(button => {
            button.addEventListener("click", function () {
                const ukuranList = JSON.parse(this.getAttribute("data-ukuran-list"));
                const ukuranModalBody = document.getElementById("ukuranModalBody");
                ukuranModalBody.innerHTML = ""; // Bersihkan isi sebelumnya
                
                if (ukuranList && ukuranList.length > 0) {
                    ukuranList.forEach(item => {
                        ukuranModalBody.innerHTML += `
                            <tr>
                                <td>${item.ukuran}</td>
                                <td>${item.panjang_badan} cm</td>
                                <td>${item.panjang_tangan} cm</td>
                                <td>${item.lebar_dada} cm</td>
                                <td>${item.stok}</td>
                            </tr>
                        `;
                    });
                } else {
                    ukuranModalBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data ukuran</td>
                        </tr>
                    `;
                }
            });
        });

        // Script untuk modal detail produk (yang sudah ada)
        const detailButtons = document.querySelectorAll(".btn-detail");
        // ... (kode yang sudah ada untuk modal detail produk)
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const detailButtons = document.querySelectorAll(".btn-detail");

        detailButtons.forEach(button => {
            button.addEventListener("click", function () {
                const title = this.getAttribute("data-title");
                const bahan = this.getAttribute("data-bahan");
                const harga = this.getAttribute("data-harga");
                const stok = this.getAttribute("data-stok");
                const ukuranList = JSON.parse(this.getAttribute("data-ukuran-list"));
                const images = JSON.parse(this.getAttribute("data-images") || "[]");

                // Set detail produk
                document.getElementById("modal-title").innerText = title;
                document.getElementById("modal-bahan").innerText = bahan;
                document.getElementById("modal-harga").innerText = harga;
                document.getElementById("modal-stok").innerText = stok;

                // Set data ukuran dalam tabel
                const ukuranTableBody = document.getElementById("modal-ukuran-body");
                ukuranTableBody.innerHTML = ""; // Bersihkan isi sebelumnya
                
                if (ukuranList && ukuranList.length > 0) {
                    ukuranList.forEach(item => {
                        ukuranTableBody.innerHTML += `
                            <tr>
                                <td>${item.ukuran}</td>
                                <td>${item.panjang_badan} cm</td>
                                <td>${item.panjang_tangan} cm</td>
                                <td>${item.lebar_dada} cm</td>
                                <td>${item.stok}</td>
                            </tr>
                        `;
                    });
                } else {
                    ukuranTableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data ukuran</td>
                        </tr>
                    `;
                }

                // Set carousel gambar
                const carouselInner = document.getElementById("carousel-inner");
                carouselInner.innerHTML = ""; // Bersihkan isi sebelumnya

                if (images && images.length > 0) {
                    images.forEach((image, index) => {
                        const activeClass = index === 0 ? "active" : "";
                        carouselInner.innerHTML += `
                            <div class="carousel-item ${activeClass}">
                                <img src="/model_baju/${image}" class="d-block w-100" style="height: 600px; object-fit: cover;">
                            </div>`;
                    });
                } else {
                    carouselInner.innerHTML = `
                        <div class="carousel-item active">
                            <img src="/default-image.jpg" class="d-block w-100" style="height: 600px; object-fit: cover;">
                        </div>`;
                }
            });
        });
    });
</script>

@endsection