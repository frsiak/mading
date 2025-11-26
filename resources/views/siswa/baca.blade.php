@extends('welcome')

@section('title', 'Baca Artikel - Siswa')

@section('content')
<section class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1><i class="bi bi-book me-3"></i>Baca Artikel</h1>
                    <p class="mb-0">Jelajahi artikel-artikel menarik dari teman-teman</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5><i class="bi bi-list-ul me-2"></i>Menu Siswa</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('siswa.dashboard') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                            <a href="{{ route('siswa.tulis') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-pencil me-2"></i>Tulis Artikel
                            </a>
                            <a href="{{ route('siswa.kelola') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-folder me-2"></i>Kelola Artikel
                            </a>
                            <a href="{{ route('siswa.baca') }}" class="list-group-item list-group-item-action active">
                                <i class="bi bi-book me-2"></i>Baca Artikel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-newspaper me-2"></i>Artikel Terpublikasi</h5>
                    </div>
                    <div class="card-body">
                        @if($artikel->count() > 0)
                            <div class="row">
                                @foreach($artikel as $item)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        @endif
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-primary">{{ $item->kategori->nama_kategori }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                                            </div>
                                            <h6 class="card-title">{{ $item->judul }}</h6>
                                            <p class="card-text text-muted small">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-person me-1"></i>{{ $item->user->nama }}
                                                </small>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-outline-danger like-btn" data-artikel-id="{{ $item->id_artikel }}">
                                                        <i class="bi bi-heart{{ Auth::user()->hasLiked($item->id_artikel) ? '-fill' : '' }}"></i>
                                                        <span class="like-count">{{ $item->likes->count() }}</span>
                                                    </button>
                                                    <small class="text-muted">
                                                        <i class="bi bi-chat me-1"></i>{{ $item->komentar->count() }}
                                                    </small>
                                                    <a href="{{ route('siswa.detail', $item->id_artikel) }}" class="btn btn-sm btn-outline-primary">
                                                        Baca <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="d-flex justify-content-center">
                                {{ $artikel->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-newspaper display-1 text-muted"></i>
                                <h5 class="text-muted mt-3">Belum ada artikel yang dipublikasi</h5>
                                <p class="text-muted">Artikel akan muncul setelah disetujui oleh admin/guru</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection