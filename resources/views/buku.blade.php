<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semua Buku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="/assets/img/logo.jpg" rel="icon" alt="Logo">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link href="{{ asset('css/buku.css') }}" rel="stylesheet">

      <link rel="icon" href="{{ asset('assets/img/logo1.png') }}" type="image/png">

</head>
<body>
  <!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-3">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3">

        <a class="navbar-brand mb-0 h1 d-flex align-items-center text-truncate" href="#" style="max-width: 75%;">
            <!-- <img src="/assets/img/logo.jpg" alt="Logo" class="navbar-logo"> -->
                         <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="navbar-logo">

            <div>
                <div class="library-title">PERPUSTAKAAN PPM-AN</div>
                <div class="library-subtitle">Pesantren Pelajar Mahasiswa Aswaja Nusantara</div>
            </div>
            <!-- <span class="fw-bold ms-1 library-name">Pesantren Pelajar Mahasiswa Aswaja Nusantara</span> -->
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

  <!-- HERO WRAPPER -->
  <section class="hero text-center">
    <div class="container">
      <h1 class="mb-2 text-white fw-bold">DAFTAR SEMUA BUKU</h1>
      <p class="lead mb-2 text-white fw-medium">Temukan buku favoritmu dengan cepat!</p>

      <!-- SEARCH FORM -->
      <form id="searchForm" class="search-form mb-5">
        <input id="searchInput" class="form-control search-input" type="search"
              placeholder="Cari Buku Anda: Penulis, Judul, ...">
        <button class="btn search-btn" type="submit">Search</button>
      </form>


      <!-- KATEGORI -->
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
                @foreach ($kategori->subkategoris as $subkategori)
                  <a href="{{ route('bukus.index', ['subkategori' => $subkategori->id]) }}#semuaBukuSection"
                     class="subkategori-link">
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

  <!-- Filter Buttons -->
  <div class="container my-4">
    <div class="d-flex flex-wrap gap-2">
      <a href="{{ url('/') }}" class="btn btn-outline-success fw-bold">Kembali</a>

      @if(request()->has('search') || request()->has('subkategori') || request()->has('kategori'))
        <a href="{{ route('bukus.index') }}" class="btn btn-outline-danger fw-bold">
          Reset Filter
        </a>
      @endif
    </div>
  </div>

  <!-- Buku List -->
  <div class="container">
    <section id="semuaBukuSection">
      <div id="semuaBukuContainer" class="d-flex flex-wrap gap-3 justify-content-start">
        @forelse ($bukus as $buku)
          <div class="d-flex flex-column align-items-center book-wrapper">
            <div class="card book-card shadow border-0 position-relative overflow-hidden">
              <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
                   alt="{{ $buku->judul }}" class="w-100 h-100 book-cover">
            </div>
            <div class="mt-2">
              <a href="{{ route('bukus.show', $buku->id) }}" class="btn btn-sm btn-light border shadow">Detail</a>
            </div>
          </div>
        @empty
          <p class="text-muted">Tidak ada buku ditemukan.</p>
        @endforelse
      </div>
    </section>

    <!-- Pagination -->
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


  <!-- Scroll to Section if Filter -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);

    // Elemen-elemen untuk SEMUA BUKU
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const subkategoriLinks = document.querySelectorAll('.subkategori-link');
    const semuaBukuContainer = document.getElementById('semuaBukuContainer');
    const allBookWrappers = semuaBukuContainer ? Array.from(semuaBukuContainer.querySelectorAll('.book-wrapper')) : [];
    const resetFilterBtn = document.getElementById('resetFilterBtn');
    const noFilteredBooksMessage = document.getElementById('noFilteredBooksMessage');
    const noInitialBooksMessage = document.getElementById('noInitialBooksMessage');

    function filterAndDisplayBooks(filterQuery = '', filterSubkategoriId = null) {
        if (!semuaBukuContainer) return;

        let foundBooks = 0;
        const lowerCaseQuery = filterQuery.toLowerCase().trim();

        allBookWrappers.forEach(buku => {
            const bukuJudul = buku.dataset.judul || '';
            const bukuPenulis = buku.dataset.penulis || '';
            const bukuSubkategoriId = buku.dataset.subkategoriId || '';

            const matchesQuery = lowerCaseQuery === '' ||
                bukuJudul.includes(lowerCaseQuery) ||
                bukuPenulis.includes(lowerCaseQuery);

            const matchesSubkategori = filterSubkategoriId === null ||
                bukuSubkategoriId === String(filterSubkategoriId);

            if (matchesQuery && matchesSubkategori) {
                buku.classList.remove('hidden');
                foundBooks++;
            } else {
                buku.classList.add('hidden');
            }
        });

        if (noFilteredBooksMessage) {
            noFilteredBooksMessage.classList.toggle('hidden', foundBooks !== 0);
        }
        if (noInitialBooksMessage) {
            const hideMessage = foundBooks > 0 || (filterQuery !== '' || filterSubkategoriId !== null);
            noInitialBooksMessage.classList.toggle('hidden', hideMessage);
        }

        const section = document.getElementById('semuaBukuSection');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'center' });

        }
    }

    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const query = searchInput.value;
            filterAndDisplayBooks(query);
            // history.pushState(null, '', `?query=${encodeURIComponent(query)}#semuaBukuSection`);
        });
    }

    subkategoriLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const subkategoriId = this.dataset.subkategoriId;
            if (searchInput) searchInput.value = '';
            filterAndDisplayBooks('', subkategoriId);
            // history.pushState(null, '', `?subkategori=${subkategoriId}#semuaBukuSection`);
        });
    });

});
</script>

</body>
</html>
