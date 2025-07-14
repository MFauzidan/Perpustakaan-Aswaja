@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Hasil pencarian untuk: <strong>{{ $query }}</strong></h2>

    @if($results->isEmpty())
        <p class="text-muted">Tidak ada buku ditemukan.</p>
    @else
        <div class="row">
            @foreach($results as $buku)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($buku->gambar)
                            <img src="{{ asset('storage/' . $buku->gambar) }}" class="card-img-top" alt="{{ $buku->judul }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $buku->judul }}</h5>
                            <p class="card-text"><small class="text-muted">oleh {{ $buku->penulis }}</small></p>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($buku->sinopsis, 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
