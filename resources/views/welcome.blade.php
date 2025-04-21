<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tri Putra Lestari</title>
    
    <link rel="shortcut icon" href="{{ asset('./assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="{{ asset('./assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/compiled/css/iconly.css') }}">

    <style>
        .card .carousel {
            border-bottom: 1px solid #eee;
        }
        .card .carousel-inner {
            border-radius: 0.25rem 0.25rem 0 0;
        }
        .card .carousel-control-prev,
        .card .carousel-control-next {
            background-color: rgba(0,0,0,0.2);
            width: 2rem;
            height: 2rem;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                @if (Route::has('login'))
                    @auth
                    <div class="header-top">
                        <div class="container">
                            <div class="logo">
                                <a href="/"><img src="{{ asset('') }}./assets/compiled/svg/logo.svg" alt="Logo"></a>
                            </div>
                            <div class="header-top-right">
    
                                <div class="dropdown">
                                    <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="avatar avatar-md2" >
                                            <img src="{{ auth()->user()->photo ? asset('storage/profile/' . auth()->user()->photo) : asset('images/default-image.webp') }}" alt="Avatar">
                                        </div>
                                        <div class="text">
                                            <h6 class="user-dropdown-name">{{ Auth::user()->nama_lengkap }}</h6>
                                            <p class="user-dropdown-status text-sm text-muted">{{ Auth::user()->email }}</p>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                                      <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                      <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                      <li><hr class="dropdown-divider"></li>
                                      <li>
                                        <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                            @csrf
                                            <button type="submit" style="all: unset; cursor: pointer">Logout</button>
                                        </form>
                                    </li>
                                    </ul>
                                </div>
    
                                <!-- Burger button responsive -->
                                <a href="#" class="burger-btn d-block d-xl-none">
                                    <i class="bi bi-justify fs-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endauth                    
                @endif

                <nav class="main-navbar">
                    <div class="container d-flex justify-content-between">
                        <ul class="navbar-nav">
                            <li class="menu-item">
                                <a href="/" class='menu-link'>
                                    <span>Tri Putra Lestari</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav d-flex flex-row ms-auto">
                            <li class="menu-item">
                                <a href="#home" class='menu-link'>
                                    <span><i class="bi bi-grid-fill"></i> Home</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#shop" class='menu-link'>
                                    <span><i class="bi bi-cart-check-fill"></i> Shop</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#about" class='menu-link'>
                                    <span><i class="bi bi-info-circle-fill"></i> About Us</span>
                                </a>
                            </li>
                            @if (Route::has('login'))
                                @auth
                                @else 
                                <li class="menu-item">
                                    <a href="/login" class='menu-link'>
                                        <span>Login</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="/register" class='menu-link'>
                                        <span>Register</span>
                                    </a>
                                </li>
                                @endauth
                            @endif
                        </ul>
                    </div>
                </nav>                
            </header>

            <div class="content-wrapper container">
                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <div id="home" class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-content">
                                            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img src="./assets/compiled/jpg/architecture1.jpg" class="d-block w-100"
                                                            alt="Image Architecture">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="./assets/compiled/jpg/bg-mountain.jpg" class="d-block w-100"
                                                            alt="Image Mountain">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="./assets/compiled/jpg/jump.jpg" class="d-block w-100" alt="Image Jump">
                                                    </div>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                                    data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt assumenda mollitia
                                                    officia dolorum eius quasi.Chocolate sesame snaps apple pie danish cupcake sweet roll
                                                    jujubes tiramisu.
                                                </p>
                                                <p class="card-text">
                                                    Gummies bonbon apple pie fruitcake icing biscuit apple pie jelly-o sweet roll. Toffee
                                                    sugar
                                                    plum sugar
                                                    plum jelly-o jujubes bonbon dessert carrot cake.
                                                    Sweet pie candy jelly. Sesame snaps biscuit sugar plum. Sweet roll topping fruitcake.
                                                    Caramels liquorice
                                                    biscuit ice cream fruitcake cotton candy tart.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="shop" class="row">
                                @foreach($model_bajus as $model)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-content">
                                            @php
                                                $gambar = json_decode($model->gambar);
                                            @endphp
                                            
                                            @if($gambar && count($gambar) > 0)
                                                <div id="carouselModel{{ $model->id }}" class="carousel slide" data-bs-ride="carousel" style="height: 20rem;">
                                                    <div class="carousel-inner h-100">
                                                        @foreach($gambar as $key => $img)
                                                        <div class="carousel-item h-100 {{ $key == 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('model_baju/' . $img) }}" class="d-block w-100 h-100" alt="Model {{ $model->nama_model }}" style="object-fit: cover;">
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @if(count($gambar) > 1)
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselModel{{ $model->id }}" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselModel{{ $model->id }}" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                    @endif
                                                </div>
                                            @else
                                                <img class="card-img-top img-fluid" src="{{ asset('images/default-image.webp') }}" alt="Default Image" style="height: 20rem; object-fit: cover;">
                                            @endif
                                            
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $model->nama_model }}</h4>
                                                <p class="card-text">
                                                    {{ Str::limit($model->keterangan, 100) }}
                                                    <br>
                                                    <small>Rp {{ number_format($model->harga, 0, ',', '.') }}</small>
                                                    <br>
                                                    <small>Bahan: {{ $model->bahanBaju->nama_bahan ?? '-' }}</small>
                                                    <br>
                                                    <small>Stok: {{ $model->stok }}</small>
                                                </p>
                                                <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#tambahKeranjangModal{{ $model->id }}">
                                                    Masukan Keranjang
                                                </button>
                                                
                                                <!-- Modal Tambah Keranjang -->
                                                <div class="modal fade" id="tambahKeranjangModal{{ $model->id }}" tabindex="-1" aria-labelledby="tambahKeranjangModalLabel{{ $model->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="tambahKeranjangModalLabel{{ $model->id }}">Tambah ke Keranjang - {{ $model->nama_model }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('keranjang.store') }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="model_baju_id" value="{{ $model->id }}">
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="ukuran_id" class="form-label">Pilih Ukuran</label>
                                                                        <select name="ukuran_id" id="ukuran_id" class="form-select" required>
                                                                            <option value="">-- Pilih Ukuran --</option>
                                                                            @foreach($model->ukurans as $ukuran)
                                                                                <option value="{{ $ukuran->id }}" {{ $ukuran->pivot->stok <= 0 ? 'disabled' : '' }}>
                                                                                    {{ $ukuran->ukuran_baju }} (Stok: {{ $ukuran->pivot->stok }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="jumlah" class="form-label">Jumlah</label>
                                                                        <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <footer>
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2025 &copy; Tri Putra Lestari</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with by <a
                                href="https://saugi.me">Tegar</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/horizontal-layout.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script>

</body>

</html>