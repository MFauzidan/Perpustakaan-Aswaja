<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $buku->judul }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/detailbuku.css') }}" rel="stylesheet">
</head>
<body>
  <div class="overlay">
    <div class="row g-5 align-items-start">
      <div class="col-md-6 text-center">
        <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul }}" class="book-image">
      </div>
      <div class="col-md-6">
        <h2>{{ $buku->judul }}</h2>
        <p><strong>Kategori :</strong> {{ $buku->kategori->nama ?? '-' }}</p>
        <p><strong>Penulis :</strong> {{ $buku->penulis }}</p>
        <p><strong>Kode Penempatan :</strong> {{ $buku->kode_penempatan }}</p>

        <hr>
        <h5>Sinopsis:</h5>
        <div class="sinopsis-detail">{!! $buku->sinopsis !!}</div>

        <a href="{{ url()->previous() }}" class="btn btn-outline-light mt-4">← Kembali</a>
      </div>
    </div>
  </div>
</body>
</html>
