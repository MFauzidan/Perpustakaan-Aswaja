@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home Perpustakaan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-3">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="/assets/img/logo.jpg" alt="Logo" style="height: 60px; margin-right: 10px; border-radius: 50%;">
      Perpustakaan Aswaja Nusantara
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
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

<!-- Hero -->
<section class="hero text-center" style="padding-top: 150px; padding-bottom: 100px;">

  <div class="container">
    <h1 class="mb-4 text-white">Selamat Datang di Perpustakaan Aswaja Nusantara</h1>
    <p class="lead mb-4 text-white">Temukan buku favoritmu dengan cepat!</p>
    <!-- ✅ Form Search AJAX -->
  <form id="searchForm" class="search-form mb-5">
    <input id="searchInput" class="form-control search-input" type="search" placeholder="Cari Buku Anda: Penulis, Judul,...">
    <button class="btn search-btn" type="submit">Search</button>
  </form>


    <!-- Kategori Buku -->
    <div class="row align-items-center justify-content-between mb-3 px-2">
      <div class="col-auto">
        <h5 class="fw-bold text-white mb-0">Kategori Buku</h5>
      </div>
    </div>

    <!-- Scrollable Container -->
    <div class="scroll-wrapper position-relative">
      <button class="scroll-btn left-btn"><i class="fas fa-chevron-left"></i></button>
      <div id="kategori-scroll" class="scroll-container d-flex">
        @foreach ($kategoris as $kategori)
          @php
              $icons = [
                  'ilmiah' => 'fas fa-flask',
                  'sejarah' => 'fas fa-landmark',
                  'islam' => 'fas fa-mosque',
                  'sosum' => 'fas fa-users',
                  'fiksi' => 'fas fa-book',
                  'teknologi' => 'fas fa-microchip',
                  'pendidikan' => 'fas fa-graduation-cap',
                  'agama' => 'fas fa-praying-hands',
                  'biografi' => 'fas fa-user',
              ];
              $icon = $icons[strtolower($kategori->nama)] ?? 'fas fa-book-open';
              $isActive = (int) $kategoriDipilih === $kategori->id;
          @endphp

          <a href="{{ route('home', ['kategori' => $kategori->id, 'sort' => request('sort')]) }}"
            class="text-decoration-none {{ $isActive ? 'bg-light border border-success' : 'text-dark' }}">
            <div class="category-card text-center border rounded p-3 shadow-sm bg-white mx-2"
                style="min-width: 160px; width: 160px;">
              <div class="icon mb-2"><i class="{{ $icon }} fa-2x text-success"></i></div>
              <div class="kategori-nama">{{ ucfirst($kategori->nama) }}</div>
            </div>
          </a>
        @endforeach
      </div>
      <button class="scroll-btn right-btn"><i class="fas fa-chevron-right"></i></button>
    </div>
  </div>
</section>

<!-- Buku Terbaru -->
<!-- Buku Terbaru -->
<section class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Buku Terbaru</h4>
    <div class="dropdown">
      <button class="btn btn-outline-success fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Urutkan
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('home', ['sort' => 'terbaru']) }}">Terbaru</a></li>
        <li><a class="dropdown-item" href="{{ route('home', ['sort' => 'terlama']) }}">Terlama</a></li>
      </ul>
    </div>
  </div>

  <div class="scroll-horizontal d-flex py-2 px-1 gap-3">
    @forelse ($bukuTerbaru as $buku)
      <div class="d-flex flex-column align-items-center" style="width: 200px;">
        <div class="card book-card shadow border-0" style="width: 200px; height: 150px;">
          <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
               alt="{{ $buku->judul }}" class="w-100 h-100" style="object-fit: cover;">
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

<!-- Semua Buku -->
<section class="container my-5">
  <!-- Tombol saja, tanpa judul -->
  <div class="d-flex justify-content-start align-items-center mb-4">
    <a href="{{ route('home') }}" class="btn btn-outline-success fw-bold">Lihat Semua Buku</a>
  </div>

  <div id="semuaBukuContainer" class="d-flex flex-wrap gap-3 justify-content-start">
    @forelse ($semuaBuku as $buku)
      <div class="d-flex flex-column align-items-center" style="width: 200px;">
        <div class="card book-card shadow border-0 position-relative overflow-hidden" style="width: 200px; height: 150px;">
          <img src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/200x150?text=No+Image' }}"
               alt="{{ $buku->judul }}" class="w-100 h-100" style="object-fit: cover;">
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


<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-3">
  <div class="container text-center">
    <img src="/assets/img/logo.jpg" alt="Logo" style="height: 100px; border-radius: 50%;">
    <h5 class="mt-3 mb-4">Pesantren Aswaja Nusantara<br>Mlangi Yogyakarta</h5>
    <p><i class="fas fa-envelope"></i> media.ppmaswaja@gmail.com</p>
    <p><i class="fab fa-whatsapp"></i> 0815 6866 002 (WhatsApp)</p>
    <div class="d-flex justify-content-center gap-3">
      <a href="https://facebook.com" target="_blank" class="btn btn-primary"><i class="fab fa-facebook-f"></i></a>
      <a href="https://instagram.com" target="_blank" class="btn btn-dark"><i class="fab fa-instagram"></i></a>
      <a href="https://youtube.com" target="_blank" class="btn btn-danger"><i class="fab fa-youtube"></i></a>
    </div>
    <p class="mt-4 mb-0">&copy; 2025 Pesantren Pelajar Mahasiswa Aswaja Nusantara</p>
  </div>
</footer>

<!-- Infinite Kategori Scroll -->
<script>
  const scrollContainer = document.getElementById('kategori-scroll');
  const leftBtn = document.querySelector('.left-btn');
  const rightBtn = document.querySelector('.right-btn');
  const originalContent = scrollContainer.innerHTML;

  scrollContainer.innerHTML += originalContent;

  let scrollStep = 1;
  let autoScroll;

  function startAutoScroll() {
    autoScroll = setInterval(() => {
      scrollContainer.scrollLeft += scrollStep;
      if (scrollContainer.scrollLeft >= scrollContainer.scrollWidth / 2) {
        scrollContainer.scrollLeft = 0;
      }
    }, 20);
  }

  function stopAutoScroll() {
    clearInterval(autoScroll);
  }

  leftBtn.addEventListener('click', () => {
    stopAutoScroll();
    scrollContainer.scrollBy({ left: -180, behavior: 'smooth' });
    setTimeout(startAutoScroll, 1000);
  });

  rightBtn.addEventListener('click', () => {
    stopAutoScroll();
    scrollContainer.scrollBy({ left: 180, behavior: 'smooth' });
    setTimeout(startAutoScroll, 1000);
  });

  scrollContainer.addEventListener('mouseenter', stopAutoScroll);
  scrollContainer.addEventListener('mouseleave', startAutoScroll);

  startAutoScroll();
</script>

<!-- ✅ AJAX Search Script -->
<script>
  document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const query = document.getElementById('searchInput').value;

    fetch(`/api/buku/search?query=${encodeURIComponent(query)}`)
      .then(response => response.json())
      .then(bukus => {
        const container = document.getElementById('semuaBukuContainer');
        container.innerHTML = '';

        if (bukus.length === 0) {
          container.innerHTML = '<p class="text-muted">Tidak ada buku ditemukan.</p>';
          return;
        }

        bukus.forEach(buku => {
          const imgSrc = buku.gambar ? `/storage/${buku.gambar}` : 'https://via.placeholder.com/200x150?text=No+Image';
          const html = `
            <div class="d-flex flex-column align-items-center" style="width: 200px;">
              <div class="card book-card shadow border-0 position-relative overflow-hidden" style="width: 200px; height: 150px;">
                <img src="${imgSrc}" alt="${buku.judul}" class="w-100 h-100" style="object-fit: cover;">
              </div>
              <div class="mt-2">
                <a href="/bukus/${buku.id}" class="btn btn-sm btn-light border shadow">Detail</a>
              </div>
            </div>
          `;
          container.insertAdjacentHTML('beforeend', html);
        });
      })
      .catch(console.error);
  });
</script>

</body>
</html>
