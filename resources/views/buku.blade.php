<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Semua Buku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="/assets/img/logo.jpg" rel="icon" alt="Logo">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="{{ asset('css/buku.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo1.png') }}" type="image/png">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-3">
        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3">
           <a class="navbar-brand mb-0 h1 d-flex flex-row align-items-center text-truncate gap-2" href="{{ route('home') }}" style="max-width: 100%;">
                <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="navbar-logo" style="height: 40px;">
                <div class="text-start">
                    <div class="library-title fw-bold" style="font-size: 0.9rem;">PERPUSTAKAAN PPM-AN</div>
                    <div class="library-subtitle" style="font-size: 0.7rem;">Pesantren Pelajar Mahasiswa Aswaja Nusantara</div>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-2 mt-lg-0" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto w-100 justify-content-end text-end mt-2 mt-lg-0">
                    <li class="nav-item"><a class="nav-link" href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram fa-lg"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="https://www.youtube.com" target="_blank"><i class="fab fa-youtube fa-lg"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook fa-lg"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero text-center">
        <div class="container">
            <h1 class="mb-2 text-white fw-semibold">DAFTAR SEMUA BUKU</h1>
            <p class="lead mb-2 text-white fw-medium">Temukan buku favoritmu dengan cepat!</p>

            <form id="searchForm" class="search-form mb-5" action="{{ route('buku.index') }}" method="GET">
                <input name="search" id="searchInput" class="form-control search-input" type="search"
                       placeholder="Cari Buku Anda: Penulis, Judul, ..."
                       value="{{ $search }}"> {{-- Mempertahankan nilai pencarian --}}
                @if($subkategori) {{-- Mempertahankan filter subkategori jika ada --}}
                    <input type="hidden" name="subkategori" value="{{ $subkategori }}">
                @endif
                <button class="btn search-btn" type="submit">Search</button>
            </form>

            <div class="row align-items-center justify-content-between mb-3 px-2">
                <div class="col-auto">
                    <h5 class="fw-bold text-white mb-0">Kategori Buku</h5>
                </div>
            </div>

            <div class="kategori-wrapper d-flex gap-3 flex-wrap justify-content-center">
                @foreach ($kategoris as $kategori)
                    <div class="dropdown-kategori position-relative">
                        <button type="button" class="kategori-btn">
                            {{ ucfirst($kategori->nama) }}
                            <i class="bi bi-caret-down-fill"></i>
                        </button>

                        @if ($kategori->subkategoris && $kategori->subkategoris->count() > 0)
                            <div class="dropdown-subkategori">
                                @foreach ($kategori->subkategoris as $subkategoriItem) {{-- Menggunakan nama yang berbeda agar tidak bentrok dengan variabel $subkategori dari request --}}
                                    {{-- Link subkategori akan mengirimkan GET request ke BukuController@index --}}
                                    <a href="{{ route('buku.index', ['subkategori' => $subkategoriItem->id, 'search' => $search]) }}#semuaBukuSection"
                                       class="subkategori-link">
                                        {{ ucfirst($subkategoriItem->nama) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="container my-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-success fw-bold">Kembali ke Beranda</a>

            @if(!empty($search) || !empty($subkategori)) {{-- Cek apakah ada filter aktif --}}
                <a href="{{ route('buku.index') }}" class="btn btn-outline-danger fw-bold">
                    Reset Filter
                </a>
            @endif
        </div>
    </div>

    <div class="container">
        <section id="semuaBukuSection">
            <div id="semuaBukuContainer" class="d-flex flex-wrap gap-3 justify-content-start">
                @forelse ($bukus as $buku) {{-- Menggunakan $bukus dari paginasi --}}
                    <div class="d-flex flex-column align-items-center book-wrapper">
                        <div class="card book-card shadow border-0 position-relative overflow-hidden" style="width: 200px; height: 250px;">
                            <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
                                alt="{{ $buku->judul }}" class="w-100 h-100 book-cover object-fit-cover">
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-light border shadow">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Tidak ada buku ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <div class="mt-4">
            {{ $bukus->withQueryString()->links() }}
        </div>
    </div>

    <footer id="footer" class="footer bg-dark text-white py-5">
        <div class="container text-center">
            <h3 class="mb-3">Pesantren Aswaja Nusantara</h3>
            <div class="mb-3">
                <strong>Alamat:</strong> Jl. Masjid Patok Negoro, Mlangi, Nogotirto, Kec. Gamping, Kabupaten Sleman, DIY 55592<br>
                <strong>Email:</strong> <a href="mailto:media.ppmaswaja@gmail.com" class="text-white">media.ppmaswaja@gmail.com</a><br>
                <strong>Whatsapp:</strong> 08156866002
            </div>
            <div class="social-links d-flex justify-content-center mb-3 gap-3">
                <a href="https://facebook.com/" target="_blank"><i class="fab fa-facebook fs-5"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram fs-5"></i></a>
                <a href="mailto:media.ppmaswaja@gmail.com"><i class="bi bi-envelope fs-5"></i></a>
            </div>
            <div class="copyright mb-2">
                © {{ date('Y') }} <strong>SD Paliyan 4 Gunungkidul</strong>. Hak cipta dilindungi undang-undang.
            </div>
            <div class="credits small">
                Dikembangkan oleh <a href="https://github.com/username" class="text-white fw-bold" target="_blank">Tim IT SD Paliyan 4</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logika untuk toggle dropdown kategori (visual saja)
            const dropdownKategoris = document.querySelectorAll('.dropdown-kategori');
            dropdownKategoris.forEach(dropdown => {
                const button = dropdown.querySelector('.kategori-btn');
                const subkategoriMenu = dropdown.querySelector('.dropdown-subkategori');

                if (button && subkategoriMenu) {
                    button.addEventListener('click', function() {
                        subkategoriMenu.classList.toggle('active');
                    });

                    document.addEventListener('click', function(event) {
                        if (!dropdown.contains(event.target)) {
                            subkategoriMenu.classList.remove('active');
                        }
                    });
                }
            });

            // Optional: Scroll ke bagian buku jika ada parameter filter
            const params = new URLSearchParams(window.location.search);
            if (params.has('search') || params.has('subkategori')) {
                const section = document.getElementById('semuaBukuSection');
                if (section) {
                    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }


        });
    </script>

</body>
</html>
