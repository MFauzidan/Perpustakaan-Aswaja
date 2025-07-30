@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Semua Buku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="icon" href="{{ asset('assets/img/logo1.png') }}" type="image/png">
    <link href="{{ asset('css/buku.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-3">
        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3">

            <a class="navbar-brand mb-0 h1 d-flex align-items-center text-truncate" href="{{ route('home') }}" style="max-width: 75%;">
                <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="navbar-logo">
                <div>
                    <div class="library-title">PERPUSTAKAAN PPM-AN</div>
                    <div class="library-subtitle">Pesantren Pelajar Mahasiswa Aswaja Nusantara</div>
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

            <div class="kategori-scroll-container">
                <div class="kategori-wrapper">
                    @foreach ($kategoris as $kategori)
                        <div class="dropdown-kategori position-relative">
                            <button type="button" class="kategori-btn">
                                {{ ucfirst($kategori->nama) }}
                                <i class="bi bi-caret-down-fill"></i>
                            </button>

                            @if ($kategori->subkategoris && $kategori->subkategoris->count() > 0)
                                <div class="dropdown-subkategori">
                                    @foreach ($kategori->subkategoris as $subkategoriItem)
                                        <a href="{{ route('buku.index', ['subkategori' => $subkategoriItem->id, 'query' => $query]) }}"
                                           class="subkategori-link" data-subkategori-id="{{ $subkategoriItem->id }}">
                                            {{ ucfirst($subkategoriItem->nama) }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="container my-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-success fw-bold">Kembali ke Beranda</a>

            {{-- Tambahkan ID pada div ini agar mudah diakses oleh JavaScript --}}
            <div id="resetFilterContainer">
                @if(!empty($query) || !empty($subkategoriDipilih)) {{-- Gunakan $subkategoriDipilih yang benar --}}
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-danger fw-bold">
                        Reset Filter
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <section id="semuaBukuSection">
            <div id="semuaBukuContainer" class="books-scroll-container">
                <div class="books-wrapper">
                    @forelse ($allBooks as $buku)
                        <div class="d-flex flex-column align-items-center book-wrapper">
                            <div class="card book-card shadow border-0 position-relative overflow-hidden">
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
            </div>
        </section>

        <div class="mt-4">
            {{ $allBooks->withQueryString()->links() }}
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
            // Fungsi untuk merender HTML dari data buku (JSON)
            function renderBooks(books, containerId, isNewBooksSection = false) {
                const container = document.getElementById(containerId);
                if (!container) return;

                let html = '';
                if (books.length === 0) {
                    html = isNewBooksSection ? '<p class="text-muted">Tidak ada buku terbaru ditemukan.</p>' :
                                                '<div class="col-12"><p class="text-muted">Tidak ada buku ditemukan.</p></div>';
                } else {
                    books.forEach(buku => {
                        const imageUrl = buku.gambar ? `{{ asset('storage') }}/${buku.gambar}` : 'https://via.placeholder.com/200x150?text=No+Image';
                        // Perhatikan bahwa di sini Anda merender untuk halaman 'Semua Buku',
                        // jadi 'isNewBooksSection' mungkin tidak relevan atau perlu disesuaikan.
                        // Saya akan asumsikan ini selalu untuk "semua buku" di sini
                        html += `
                            <div class="d-flex flex-column align-items-center book-wrapper">
                                <div class="card book-card shadow border-0 position-relative overflow-hidden">
                                    <img src="${imageUrl}" alt="${buku.judul}" class="w-100 h-100 book-cover object-fit-cover">
                                </div>
                                <div class="mt-2">
                                    <a href="{{ url('buku') }}/${buku.id}" class="btn btn-sm btn-light border shadow">Detail</a>
                                </div>
                            </div>
                        `;
                    });
                }
                container.querySelector('.books-wrapper').innerHTML = html;
            }

            // Fungsi untuk mengirim permintaan AJAX dan memperbarui DOM
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

                // *** PERUBAHAN KRUSIAL DI SINI: Ganti route('home') menjadi route('buku.index') ***
                const url = `{{ route('buku.index') }}?${currentParams.toString()}`;

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

                    renderBooks(data.allBooks, 'semuaBukuContainer', false); // Render buku
                    
                    // Update nilai input tersembunyi
                    document.getElementById('searchInput').value = currentParams.get('query') || '';
                    document.getElementById('hiddenSubkategori').value = currentParams.get('subkategori') || '';
                    document.getElementById('hiddenSortAllBooks').value = currentParams.get('sort_all_books') || 'desc';
                    document.getElementById('hiddenSortNewBooks').value = currentParams.get('sort_new_books') || 'desc';

                    // *** PERUBAHAN KRUSIAL DI SINI: Tambahkan history.pushState ***
                    const newUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname}?${currentParams.toString()}`;
                    history.pushState({ path: newUrl }, '', newUrl);

                    // *** PERUBAHAN KRUSIAL DI SINI: Logika untuk menampilkan/menyembunyikan tombol Reset Filter ***
                    const resetFilterContainer = document.getElementById('resetFilterContainer');
                    const currentQuery = currentParams.get('query');
                    const currentSubkategori = currentParams.get('subkategori');

                    if (currentQuery || currentSubkategori) {
                        // Jika ada query atau subkategori, tampilkan tombol reset
                        resetFilterContainer.innerHTML = `
                            <a href="{{ route('buku.index') }}" class="btn btn-outline-danger fw-bold">
                                Reset Filter
                            </a>
                        `;
                    } else {
                        // Jika tidak ada filter, sembunyikan tombol reset
                        resetFilterContainer.innerHTML = '';
                    }

                } catch (error) {
                    console.error('Error fetching books:', error);
                }
            }

            // Search Form
            const searchForm = document.getElementById('searchForm');
            // Pastikan action form juga mengarah ke buku.index jika itu yang Anda inginkan
            // searchForm.setAttribute('action', '{{ route('buku.index') }}'); // Ini sebenarnya tidak perlu jika form method="GET" dan di-handle JS
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const query = document.getElementById('searchInput').value;
                fetchBooksAndUpdate({ query: query, subkategori: null });
            });

            // Dropdown Kategori & Subkategori
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
                        // Hapus `query` dari `fetchBooksAndUpdate` jika Anda ingin filter kategori tidak mereset pencarian.
                        // Namun, jika ingin pencarian tetap ada saat subkategori dipilih, biarkan `query: currentParams.get('query')`
                        fetchBooksAndUpdate({ subkategori: subkategoriId, query: document.getElementById('searchInput').value }); 
                        subkategoriMenu.classList.remove('active');
                    });
                });
            });

            // Initialize scroll containers
            function initScrollContainers() {
                const booksContainer = document.querySelector('.books-scroll-container');
                const kategoriContainer = document.querySelector('.kategori-scroll-container');

                if (window.innerWidth < 768) {
                    // Mobile view - enable horizontal scrolling
                    if (booksContainer) {
                        booksContainer.classList.add('scroll-container-mobile');
                    }
                    if (kategoriContainer) {
                        kategoriContainer.classList.add('scroll-container-mobile');
                    }
                } else {
                    // Desktop view - normal layout
                    if (booksContainer) {
                        booksContainer.classList.remove('scroll-container-mobile');
                    }
                    if (kategoriContainer) {
                        kategoriContainer.classList.remove('scroll-container-mobile');
                    }
                }
            }

            // Initialize on load and on resize
            initScrollContainers();
            window.addEventListener('resize', initScrollContainers);

            // Panggil ini saat halaman dimuat untuk mengecek filter awal
            // Ini akan memastikan tombol reset muncul jika halaman dimuat dengan filter aktif
            const initialQuery = document.getElementById('searchInput').value;
            const initialSubkategori = document.getElementById('hiddenSubkategori').value;
            const resetFilterContainer = document.getElementById('resetFilterContainer');

            if (initialQuery || initialSubkategori) {
                resetFilterContainer.innerHTML = `
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-danger fw-bold">
                        Reset Filter
                    </a>
                `;
            } else {
                resetFilterContainer.innerHTML = '';
            }
        });
    </script>
</body>
</html>