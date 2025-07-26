@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Favicons -->
    <link href="/assets/img/logo.jpg" rel="icon" >

    <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
    <style>
        /* Gaya tambahan untuk menyembunyikan buku yang tidak cocok */
        .book-wrapper.hidden {
            display: none !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-3">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3">

        <a class="navbar-brand mb-0 h1 d-flex align-items-center text-truncate" href="#" style="max-width: 75%;">
            <img src="/assets/img/logo.jpg" alt="Logo" class="navbar-logo">
            <span class="fw-bold ms-2 library-name">Perpustakaan Pesantren Pelajar Mahasiswa Aswaja Nusantara PPM-AN</span>
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
        <h1 class="mb-2 text-white">Selamat Datang di Perpustakaan Aswaja Nusantara</h1>
        <p class="lead mb-2 text-white">Temukan buku favoritmu dengan cepat!</p>
        <p class="text-white mb-4">Perpustakaan ini menyediakan ribuan koleksi buku yang bisa kamu akses dengan mudah.</p>

        {{-- Hapus action dan method, tambahkan ID untuk JavaScript --}}
        <form id="searchForm" class="search-form mb-5">
            <input name="query" id="searchInput" class="form-control search-input" type="search"
                   placeholder="Cari Buku Anda: Penulis, Judul,..."
                   value="{{ $query }}">
            <button class="btn search-btn" type="submit">Search</button>
        </form>

        <div class="row align-items-center justify-content-between mb-3 px-2">
            <div class="col-auto">
                <h5 class="fw-bold text-white mb-0">Kategori Buku</h5>
            </div>
        </div>

        <div class="kategori-wrapper d-flex gap-3 justify-content-center">
            @foreach ($kategoris as $kategori)
                <div class="dropdown-kategori position-relative">
                    <button type="button" class="kategori-btn">
                        {{ ucfirst($kategori->nama) }}
                        <i class="bi bi-caret-down-fill"></i>
                    </button>

                    @if ($kategori->subkategoris && $kategori->subkategoris->count() > 0)
                        <div class="dropdown-subkategori">
                            @foreach ($kategori->subkategoris as $subkategori)
                                {{-- Ubah href menjadi data-subkategori-id dan data-kategori-id --}}
                                <a href="#" class="subkategori-link"
                                   data-subkategori-id="{{ $subkategori->id }}"
                                   data-kategori-id="{{ $kategori->id }}">
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
        {{-- Tombol "Lihat Semua Buku" ini untuk mereset filter --}}
        <!-- <button id="resetFilterBtn" class="btn btn-outline-success fw-bold">Lihat Semua Buku</button> -->
         <!-- <a href="{{ route('bukus.index') }}" class="btn btn-outline-success fw-bold" target="_blank">Lihat Semua Buku</a> -->
         <a href="{{ route('bukus.index') }}" class="btn btn-outline-success fw-bold">Lihat Semua Buku</a>
    </div>

    <div id="semuaBukuContainer" class="d-flex flex-wrap gap-3 justify-content-start">
        {{-- Loop semua buku yang relevan. Tambahkan data-kategori-id, data-subkategori-id, data-judul, dan data-penulis --}}
        @forelse ($allBooksForFiltering as $buku)
            <div class="d-flex flex-column align-items-center book-wrapper"
                 data-kategori-id="{{ $buku->kategori_id }}"
                 data-subkategori-id="{{ $buku->subkategori_id }}"
                 data-judul="{{ Str::lower($buku->judul) }}"
                 data-penulis="{{ Str::lower($buku->penulis) }}">
                <div class="card book-card shadow border-0 position-relative overflow-hidden">
                    <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
                        alt="{{ $buku->judul }}" class="w-100 h-100 book-cover">
                </div>
                <div class="mt-2">
                    <a href="{{ route('bukus.show', $buku->id) }}" class="btn btn-sm btn-light border shadow">Detail</a>
                </div>
            </div>
        @empty
            {{-- Ini akan ditampilkan jika $allBooksForFiltering kosong dari controller --}}
            <p class="text-muted" id="noInitialBooksMessage">Tidak ada buku ditemukan.</p>
        @endforelse
    </div>
    <!-- <div id="noFilteredBooksMessage" class="text-muted mt-3 hidden">Tidak ada buku yang cocok dengan filter Anda.</div> -->
</section>

<!-- BUKU TERBARU -->

<section id="bukuTerbaruSection" class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 fw-bold">Buku Terbaru</h4>
        <div class="dropdown">
            <button class="btn btn-outline-success fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Urutkan
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item sort-item" data-sort="terbaru">Terbaru</a></li>
                <li><a class="dropdown-item sort-item" data-sort="terlama">Terlama</a></li>
            </ul>
        </div>
    </div>

    <div class="scroll-horizontal d-flex py-2 px-1 gap-3" id="bukuTerbaruContainer">
        @forelse ($bukuTerbaruUntukJS as $buku)
            <div class="d-flex flex-column align-items-center book-wrapper" data-timestamp="{{ $buku->created_at->timestamp }}">
                <div class="card book-card shadow border-0">
                    <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
                        alt="{{ $buku->judul }}" class="w-100 h-100 book-cover">
                </div>
                <div class="mt-2">
                    <a href="{{ route('bukus.show', $buku->id) }}" class="btn btn-sm btn-light border shadow">Detail</a>
                </div>
            </div>
        @empty
            <p class="text-muted">Tidak ada buku terbaru ditemukan.</p>
        @endforelse
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
        const params = new URLSearchParams(window.location.search);

        // --- Variabel & Elemen DOM untuk "Lihat Semua Buku" ---
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const subkategoriLinks = document.querySelectorAll('.subkategori-link');
        const semuaBukuContainer = document.getElementById('semuaBukuContainer');
        const allBookWrappers = Array.from(semuaBukuContainer.querySelectorAll('.book-wrapper')); // Ambil semua buku di DOM
        const resetFilterBtn = document.getElementById('resetFilterBtn');
        const noFilteredBooksMessage = document.getElementById('noFilteredBooksMessage');
        const noInitialBooksMessage = document.getElementById('noInitialBooksMessage');


        // Fungsi untuk memfilter dan menampilkan buku
        function filterAndDisplayBooks(filterQuery = '', filterSubkategoriId = null) {
            let foundBooks = 0;
            const lowerCaseQuery = filterQuery.toLowerCase().trim();

            allBookWrappers.forEach(buku => {
                const bukuJudul = buku.dataset.judul;
                const bukuPenulis = buku.dataset.penulis;
                const bukuSubkategoriId = buku.dataset.subkategoriId;

                const matchesQuery = lowerCaseQuery === '' ||
                                     bukuJudul.includes(lowerCaseQuery) ||
                                     bukuPenulis.includes(lowerCaseQuery);

                const matchesSubkategori = filterSubkategoriId === null ||
                                           bukuSubkategoriId === String(filterSubkategoriId); // Pastikan perbandingan string

                if (matchesQuery && matchesSubkategori) {
                    buku.classList.remove('hidden');
                    foundBooks++;
                } else {
                    buku.classList.add('hidden');
                }
            });

            // Tampilkan atau sembunyikan pesan "Tidak ada buku yang cocok"
            if (foundBooks === 0) {
                noFilteredBooksMessage.classList.remove('hidden');
            } else {
                noFilteredBooksMessage.classList.add('hidden');
            }

            // Sembunyikan pesan "Tidak ada buku ditemukan." jika ada buku yang difilter
            if (noInitialBooksMessage) {
                if (foundBooks > 0 || (filterQuery !== '' || filterSubkategoriId !== null)) {
                    noInitialBooksMessage.classList.add('hidden');
                } else {
                    noInitialBooksMessage.classList.remove('hidden');
                }
            }

            // Scroll ke section semua buku setelah filter diterapkan
            const section = document.getElementById('semuaBukuSection');
            if (section) {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Event Listener untuk Form Pencarian
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman
            const query = searchInput.value;
            filterAndDisplayBooks(query);
            // Opsional: perbarui URL tanpa reload
            history.pushState(null, '', `?query=${encodeURIComponent(query)}#semuaBukuSection`);
        });

        // Event Listener untuk Link Subkategori
        subkategoriLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah reload halaman
                const subkategoriId = this.dataset.subkategoriId;
                searchInput.value = ''; // Kosongkan input pencarian saat filter subkategori
                filterAndDisplayBooks('', subkategoriId); // Filter hanya berdasarkan subkategori
                // Opsional: perbarui URL tanpa reload
                history.pushState(null, '', `?subkategori=${subkategoriId}#semuaBukuSection`);
            });
        });

        // Event Listener untuk Tombol "Lihat Semua Buku" (reset filter)
        resetFilterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            searchInput.value = ''; // Kosongkan input pencarian
            filterAndDisplayBooks(); // Panggil tanpa argumen untuk menampilkan semua buku
            history.pushState(null, '', `{{ route('home') }}#semuaBukuSection`); // Kembali ke URL home
        });

        // Inisialisasi awal berdasarkan parameter URL saat halaman dimuat
        const initialQuery = params.get('query') || '';
        const initialSubkategori = params.get('subkategori') || null;
        if (initialQuery !== '' || initialSubkategori !== null) {
            searchInput.value = initialQuery; // Set nilai input pencarian jika ada di URL
            filterAndDisplayBooks(initialQuery, initialSubkategori);
        } else {
            // Tampilkan semua buku jika tidak ada filter awal
            filterAndDisplayBooks();
        }

        // --- Kode JavaScript untuk pengurutan buku terbaru/terlama (yang sudah ada) ---
        // const sortButtons = document.querySelectorAll('.sort-item');
        // const bukuTerbaruContainer = document.getElementById('bukuTerbaruContainer');
        // const dropdownToggleButton = document.querySelector('#bukuTerbaruSection .dropdown-toggle');

        // let bukuItems = Array.from(bukuTerbaruContainer.querySelectorAll('.book-wrapper'));

        // function sortAndDisplayBooks(order) {
        //     if (bukuItems.length === 0) {
        //         bukuTerbaruContainer.innerHTML = '<p class="text-muted">Tidak ada buku ditemukan.</p>';
        //         return;
        //     }

        //     if (order === 'terbaru') {
        //         bukuItems.sort((a, b) => {
        //             const timestampA = parseInt(a.dataset.timestamp);
        //             const timestampB = parseInt(b.dataset.timestamp);
        //             return timestampB - timestampA;
        //         });
        //     } else if (order === 'terlama') {
        //         bukuItems.sort((a, b) => {
        //             const timestampA = parseInt(a.dataset.timestamp);
        //             const timestampB = parseInt(b.dataset.timestamp);
        //             return timestampA - timestampB;
        //         });
        //     }

        //     bukuTerbaruContainer.innerHTML = '';
        //     bukuItems.forEach(buku => {
        //         bukuTerbaruContainer.appendChild(buku);
        //     });
        // }

        // sortButtons.forEach(button => {
        //     button.addEventListener('click', function(e) {
        //         e.preventDefault();
        //         const sortType = this.dataset.sort;
        //         if (dropdownToggleButton) {
        //             dropdownToggleButton.textContent = sortType === 'terbaru' ? 'Terbaru' : 'Terlama';
        //         }
        //         sortAndDisplayBooks(sortType);
        //     });
        // });

        // const initialSort = params.get('sort') || 'terbaru';
        // sortAndDisplayBooks(initialSort);
        // if (dropdownToggleButton) {
        //     dropdownToggleButton.textContent = initialSort === 'terbaru' ? 'Terbaru' : 'Terlama';
        // }

        // if (params.get('sort') && !window.location.hash) {
        //     const terbaruSection = document.getElementById('bukuTerbaruSection');
        //     if (terbaruSection) {
        //         terbaruSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        //     }
        // }
    });
</script>

</body>
</html>
