@extends('welcome')

@section('title', 'Kelola Artikel - Guru')

@section('content')
<section class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1><i class="bi bi-folder me-3"></i>Kelola Artikel Saya</h1>
                    <p class="mb-0">Edit dan kelola semua artikel yang telah Anda tulis</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured-posts section">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <div class="row gy-4">
            @forelse($artikel as $item)
            <div class="col-md-6 col-lg-4">
                <article class="blog-card">
                    <div class="blog-image">
                        <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/img/blog/blog-post-square-1.webp') }}" alt="{{ $item->judul }}" loading="lazy">
                        <div class="category-badge">{{ $item->kategori->nama_kategori }}</div>
                    </div>
                    <div class="blog-content">
                        <div class="author-info">
                            <div class="author-details">
                                <span class="author-name">{{ $item->user->nama }}</span>
                                <span class="publish-date">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <h3><a href="{{ route('artikel.detail', $item->id_artikel) }}">{{ $item->judul }}</a></h3>
                        <p>{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                        <div class="blog-footer">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-{{ $item->status == 'published' ? 'success' : ($item->status == 'draft' ? 'warning' : 'danger') }}">
                                    {{ $item->status == 'published' ? 'Published' : ($item->status == 'draft' ? 'Draft' : 'Ditolak') }}
                                </span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('guru.edit', $item->id_artikel) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="{{ route('artikel.detail', $item->id_artikel) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('guru.download', $item->id_artikel) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-download"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-file-text" style="font-size: 4rem; color: #6c757d;"></i>
                    <h4 class="mt-3">Belum ada artikel</h4>
                    <p class="text-muted">Mulai menulis artikel pertama Anda dan bagikan dengan komunitas</p>
                    <a href="{{ route('guru.tulis') }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Tulis Artikel Pertama
                    </a>
                </div>
            </div>
            @endforelse
        </div>
        
        @if($artikel->hasPages())
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $artikel->links() }}
            </div>
        </div>
        @endif
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('guru.tulis') }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil"></i> Tulis Artikel Baru
                </a>
                <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</section>
@endsection