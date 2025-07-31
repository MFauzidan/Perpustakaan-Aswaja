@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="icon" href="{{ asset('assets/img/logo1.png') }}" type="image/png">
    <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-3">
  <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3">

    <a class="navbar-brand mb-0 h1 d-flex align-items-center gap-2 text-truncate" href="{{ route('home') }}" style="max-width: 75%;">
      <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="navbar-logo">
      <div class="text-start">
        <div class="library-title">PERPUSTAKAAN PPM-AN</div>
        <div class="library-subtitle">Pesantren Pelajar Mahasiswa Aswaja Nusantara</div>
      </div>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse mt-2 mt-lg-0" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto w-100 justify-content-end text-end mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="https://www.instagram.com" target="_blank">
            <i class="fab fa-instagram fa-lg"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.youtube.com" target="_blank">
            <i class="fab fa-youtube fa-lg"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.facebook.com" target="_blank">
            <i class="fab fa-facebook fa-lg"></i>
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>


<section class="hero text-center">
    <div class="container">
        <h1 class="mb-2 text-white fw-bold">Selamat Datang di Perpustakaan Aswaja Nusantara</h1>
        <p class="lead mb-2 text-white fw-medium">Temukan buku favoritmu dengan cepat!</p>
        <p class="text-white mb-4">Perpustakaan ini menyediakan ribuan koleksi buku yang bisa kamu akses dengan mudah.</p>

        <form id="searchForm" class="search-form mb-5" action="{{ route('home') }}" method="GET">
            <input name="query" id="searchInput" class="form-control search-input" type="search"
                   placeholder="Cari Buku Anda: Penulis, Judul,..."
                   value="{{ $query }}">
            <input type="hidden" name="subkategori" id="hiddenSubkategori" value="{{ $subkategoriDipilih ?? '' }}">
            <input type="hidden" name="sort_all_books" id="hiddenSortAllBooks" value="{{ $sortOrderAllBooks ?? 'desc' }}">
            <input type="hidden" name="sort_new_books" id="hiddenSortNewBooks" value="{{ $sortOrderNewBooks ?? 'desc' }}">
            <button class="btn search-btn" type="submit">Search</button>
        </form>

        <div class="row align-items-center justify-content-between mb-3 px-2">
            <div class="col-auto">
                <h5 class="fw-bold text-white mb-0">Kategori Buku</h5>
            </div>
        </div>

        <div class="kategori-container">
            @foreach ($kategoris as $kategori)
                <div class="dropdown-kategori position-relative">
                    <button type="button" class="kategori-btn">
                        {{ ucfirst($kategori->nama) }}
                        <i class="bi bi-caret-down-fill"></i>
                    </button>
                    @if ($kategori->subkategoris && $kategori->subkategoris->count() > 0)
                        <div class="dropdown-subkategori">
                            @foreach ($kategori->subkategoris as $subkategori)
                                <a href="#" data-subkategori-id="{{ $subkategori->id }}" class="subkategori-link">
                                    {{ ucfirst($subkategori->nama) }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</section>

<section id="semuaBukuSection" class="container my-5">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <a href="{{ route('buku.index') }}" class="btn btn-outline-success fw-bold">Lihat Semua Buku</a>
    </div>

    <div class="horizontal-scroll-container">
        <div class="horizontal-scroll-wrapper" id="semuaBukuContainer">
            @forelse ($allBooks as $buku)
                <div class="book-item">
                    <div class="card book-card shadow border-0 position-relative overflow-hidden">
                        <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
                            alt="{{ $buku->judul }}" class="w-100 h-100 book-cover object-fit-cover">
                    </div>
                    <div class="mt-2 text-center">
                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-light border shadow">Detail</a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">Tidak ada buku ditemukan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section id="bukuTerbaruSection" class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 fw-bold">Buku Terbaru</h4>
        <div class="dropdown">
            <button class="btn btn-outline-success fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown" id="sortNewBooksButton">
                Urutkan: {{ ($sortOrderNewBooks ?? 'desc') == 'desc' ? 'Terbaru' : 'Terlama' }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item sort-item" href="#" data-sort-order="desc">Terbaru</a></li>
                <li><a class="dropdown-item sort-item" href="#" data-sort-order="asc">Terlama</a></li>
            </ul>
        </div>
    </div>

    <div class="horizontal-scroll-container">
        <div class="horizontal-scroll-wrapper" id="bukuTerbaruContainer">
            @forelse ($bukuTerbaru as $buku)
                <div class="book-item">
                    <div class="card book-card shadow border-0">
                        <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
                            alt="{{ $buku->judul }}" class="w-100 h-100 book-cover">
                    </div>
                    <div class="mt-2 text-center">
                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-light border shadow">Detail</a>
                    </div>
                </div>
            @empty
                <p class="text-muted">Tidak ada buku terbaru ditemukan.</p>
            @endforelse
        </div>
    </div>
</section>

<footer id="footer" class="footer bg-dark text-white py-5">
    <div class="container text-center">
        <h3 class="mb-3">Pesantren Aswaja Nusantara</h3>
        <div class="mb-3">
            <strong>Alamat:</strong> Jl. Masjid Patok Negoro, Mlangi, Nogotirto, Kec. Gamping, Kabupaten Sleman, DIY 55592<br>
            <strong>Email:</strong> <a href="mailto:media.ppmaswaja@gmail.com" class="text-white">media.ppmaswaja@gmail.com</a><br>
            <strong>Whatsapp:</strong> 08156866002
        </div>
        <div class="social-links d-flex justify-content-center mb-3 gap-3">
            <a href="https://facebook.com/" target="_blank"><i class="bi bi-facebook fs-5"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram fs-5"></i></a>
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
        // --- Fungsi untuk merender HTML dari data buku (JSON) ---
        function renderBooks(books, containerId, isNewBooksSection = false) {
            const container = document.querySelector(`#${containerId}`);
            if (!container) return;

            let html = '';
            if (books.length === 0) {
                html = isNewBooksSection ? '<p class="text-muted">Tidak ada buku terbaru ditemukan.</p>' :
                                       '<div class="col-12"><p class="text-muted">Tidak ada buku ditemukan.</p></div>';
            } else {
                books.forEach(buku => {
                    const imageUrl = buku.gambar ? `{{ asset('storage') }}/${buku.gambar}` : 'https://via.placeholder.com/200x150?text=No+Image';
                    if (isNewBooksSection) {
                        html += `
                            <div class="book-item">
                                <div class="card book-card shadow border-0">
                                    <img src="${imageUrl}" alt="${buku.judul}" class="w-100 h-100 book-cover">
                                </div>
                            </div>
                        `;
                    } else {
                        html += `
                            <div class="book-item">
                                <div class="card book-card shadow border-0 position-relative overflow-hidden">
                                    <img src="${imageUrl}" alt="${buku.judul}" class="w-100 h-100 book-cover object-fit-cover">
                                </div>
                                <div class="mt-2 text-center">
                                    <a href="{{ url('buku') }}/${buku.id}" class="btn btn-sm btn-light border shadow">Detail</a>
                                </div>
                            </div>
                        `;
                    }
                });
            }
            container.innerHTML = html;
        }

        // --- Fungsi untuk mengirim permintaan AJAX dan memperbarui DOM ---
        async function fetchBooksAndUpdate(params) {
            const searchForm = document.getElementById('searchForm');
            const formData = new FormData(searchForm);
            const currentParams = new URLSearchParams();

            for (let pair of formData.entries()) {
                currentParams.append(pair[0], pair[1]);
            }

            for (const key in params) {
                if (params[key] !== null) {
                    currentParams.set(key, params[key]);
                } else {
                    currentParams.delete(key);
                }
            }

            const url = `{{ route('home') }}?${currentParams.toString()}`;

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                renderBooks(data.allBooks, 'semuaBukuContainer', false);
                renderBooks(data.bukuTerbaru, 'bukuTerbaruContainer', true);

                const sortNewBooksButton = document.getElementById('sortNewBooksButton');
                if (sortNewBooksButton) {
                    sortNewBooksButton.textContent = 'Urutkan: ' + data.sortOrderNewBooksText;
                }

                document.getElementById('searchInput').value = currentParams.get('query') || '';
                document.getElementById('hiddenSubkategori').value = currentParams.get('subkategori') || '';
                document.getElementById('hiddenSortAllBooks').value = currentParams.get('sort_all_books') || 'desc';
                document.getElementById('hiddenSortNewBooks').value = currentParams.get('sort_new_books') || 'desc';

                const newUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname}?${currentParams.toString()}`;
                history.pushState({ path: newUrl }, '', newUrl);

            } catch (error) {
                console.error('Error fetching books:', error);
            }
        }

        // --- Logika Search Form ---
        const searchForm = document.getElementById('searchForm');
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const query = document.getElementById('searchInput').value;
            fetchBooksAndUpdate({ query: query, subkategori: null });
        });

        // --- Logika Dropdown Kategori & Subkategori ---
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

            const subkategoriLinks = dropdown.querySelectorAll('.subkategori-link');
            subkategoriLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const subkategoriId = event.target.dataset.subkategoriId;
                    fetchBooksAndUpdate({ subkategori: subkategoriId, query: null });
                    subkategoriMenu.classList.remove('active');
                });
            });
        });

        // --- Logika Sort Buku Terbaru/Terlama ---
        const sortButtonsNewBooks = document.querySelectorAll('#bukuTerbaruSection .sort-item');
        sortButtonsNewBooks.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const sortOrder = event.target.dataset.sortOrder;
                fetchBooksAndUpdate({ sort_new_books: sortOrder });
            });
        });

        // Initialize scroll containers
        function initScrollContainers() {
            const scrollContainers = document.querySelectorAll('.horizontal-scroll-container');

            if (window.innerWidth < 768) {
                scrollContainers.forEach(container => {
                    container.classList.add('mobile-scroll');
                });
            } else {
                scrollContainers.forEach(container => {
                    container.classList.remove('mobile-scroll');
                });
            }
        }

        // Initialize on load and on resize
        initScrollContainers();
        window.addEventListener('resize', initScrollContainers);
    });
</script>

</body>
</html>
