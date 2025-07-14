<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semua Kategori</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/kategori.css') }}">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">Perpustakaan</a>
  </div>
</nav>

<!-- Semua Kategori -->
<section class="container py-5">
  <h2 class="text-center mb-4">Semua Kategori Buku</h2>
  <div class="row row-cols-2 row-cols-md-4 g-4">
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
      @endphp
      <div class="col">
        <a href="{{ route('home', ['kategori' => $kategori->nama]) }}" class="text-decoration-none text-dark">
          <div class="category-card text-center">
            <div class="icon mb-2"><i class="{{ $icon }} fa-2x"></i></div>
            <div class="kategori-nama">{{ $kategori->nama }}</div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</section>

</body>
</html>
            