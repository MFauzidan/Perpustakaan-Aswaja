<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semua Buku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link href="{{ asset('css/buku.css') }}" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-3">
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between px-2 px-md-3">
      <a class="navbar-brand mb-0 h1 d-flex align-items-center text-truncate" href="/">
        <img src="/assets/img/logo.jpg" alt="Logo" class="navbar-logo" height="40">
        <span class="fw-bold ms-2">Perpustakaan PPM-AN</span>
      </a>
    </div>
  </nav>

  <!-- HERO WRAPPER -->
  <section class="hero text-center">
    <div class="container">
      <h1 class="mb-2 text-white">Daftar Semua Buku</h1>
      <p class="lead mb-2 text-white">Temukan buku favoritmu dengan cepat!</p>

      <!-- SEARCH FORM -->
      <form action="{{ route('bukus.index') }}#semuaBukuSection" method="GET" class="search-form mb-5">
        <input name="search" class="form-control search-input" type="search"
               placeholder="Cari Buku Anda: Penulis, Judul, ..."
               value="{{ request('search') }}">
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

  <!-- Scroll to Section if Filter -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const params = new URLSearchParams(window.location.search);
      const adaFilter = params.get('search') || params.get('subkategori') || params.get('kategori');

      if (adaFilter) {
        const section = document.getElementById('semuaBukuSection');
        if (section && !window.location.hash) {
          const yOffset = -120;
          const y = section.getBoundingClientRect().top + window.pageYOffset + yOffset;

          window.scrollTo({
            top: y,
            behavior: 'smooth'
          });
        }
      }
    });
  </script>
</body>
</html>
