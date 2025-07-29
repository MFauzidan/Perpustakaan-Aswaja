<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $buku->judul }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="/assets/img/logo.jpg" rel="icon" alt="Logo">


  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo1.png') }}" type="image/png">


  <!-- Custom CSS -->
  <link href="{{ asset('css/detailbuku.css') }}" rel="stylesheet">
</head>
<body>
<div class="overlay">
  <div class="row g-4 align-items-start">
    <div class="col-12 col-md-6 text-center">
      <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul }}" class="book-image">
    </div>
    <div class="col-12 col-md-6">
      <h2>{{ $buku->judul }}</h2>
      <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
      <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
      <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
      <p><strong>Jumlah Halaman:</strong> {{ $buku->jumlah_halaman }} halaman</p>
      <p><strong>Kategori:</strong> {{ $buku->kategori->nama }}</p>
      <p><strong>Lokasi Rak:</strong> {{ $buku->kode_penempatan }}</p>
      <p><strong>Stok Tersedia:</strong> {{ $buku->jumlah_asli }} dari {{ $buku->jumlah_sekarang }} buku</p>

      <hr>
      <h5>Sinopsis:</h5>
      <div class="sinopsis-detail">{!! $buku->sinopsis !!}</div>

      <a href="{{ url()->previous() }}" class="btn btn-outline-light mt-4">← Kembali</a>
    </div>
  </div>
</div>

</body>
</html>
