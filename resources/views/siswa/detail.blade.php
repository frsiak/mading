@extends('welcome')

@section('title', $artikel->judul . ' - Detail Artikel')

@section('content')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Artikel Content -->
                <article class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('siswa.baca') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-primary fs-6">{{ $artikel->kategori->nama_kategori }}</span>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y, H:i') }}</small>
                        </div>
                        
                        <h1 class="mb-3">{{ $artikel->judul }}</h1>
                        
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="bi bi-person-circle fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <strong>{{ $artikel->user->nama }}</strong><br>
                                    <small class="text-muted">{{ ucfirst($artikel->user->role) }}</small>
                                </div>
                            </div>
                            
                            <!-- Like Button -->
                            <div class="article-actions">
                                <button class="btn btn-outline-danger like-btn" data-artikel-id="{{ $artikel->id_artikel }}">
                                    <i class="bi bi-heart{{ Auth::user()->hasLiked($artikel->id_artikel) ? '-fill' : '' }}"></i>
                                    <span class="like-count">{{ $artikel->likes->count() }}</span>
                                </button>
                                
                                <span class="ms-3 text-muted">
                                    <i class="bi bi-chat"></i>
                                    {{ $artikel->komentar->count() }} komentar
                                </span>
                            </div>
                        </div>
                        
                        @if($artikel->foto)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $artikel->foto) }}" class="img-fluid rounded" alt="{{ $artikel->judul }}">
                        </div>
                        @endif
                        
                        <div class="article-content">
                            {!! nl2br(e($artikel->isi)) !!}
                        </div>
                    </div>
                </article>

                <!-- Komentar Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-dots me-2"></i>Komentar ({{ $artikel->komentar->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Form Komentar -->
                        <form action="{{ route('artikel.comment', $artikel->id_artikel) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tulis Komentar</label>
                                <textarea name="komentar" class="form-control" rows="3" placeholder="Bagikan pendapat Anda tentang artikel ini..." required></textarea>
                                @error('komentar')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>Kirim Komentar
                            </button>
                        </form>

                        <!-- Daftar Komentar -->
                        @if($artikel->komentar->count() > 0)
                            <div class="comments-list">
                                @foreach($artikel->komentar as $komentar)
                                <div class="comment-item border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>{{ $komentar->user->nama }}</strong>
                                                <div class="d-flex align-items-center gap-2">
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($komentar->tanggal)->diffForHumans() }}</small>
                                                    @if(Auth::user() && (Auth::user()->role === 'admin' || Auth::user()->role === 'guru' || Auth::user()->id_user === $komentar->id_user))
                                                    <form action="{{ route('comment.delete', $komentar->id_komentar) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="mb-0">{{ $komentar->komentar }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-chat display-4 text-muted"></i>
                                <p class="text-muted mt-2">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-md-4">
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
                            <a href="{{ route('siswa.baca') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-book me-2"></i>Baca Artikel
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Info Artikel -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6><i class="bi bi-info-circle me-2"></i>Info Artikel</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Penulis</td>
                                <td>{{ $artikel->user->nama }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>{{ $artikel->kategori->nama_kategori }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Komentar</td>
                                <td>{{ $artikel->komentar->count() }} komentar</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('styles')
<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    text-align: justify;
}

.comment-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

.comments-list {
    max-height: 500px;
    overflow-y: auto;
}

.comment-item {
    transition: background-color 0.2s ease;
}

.comment-item:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 12px;
    margin: -12px -12px 12px -12px;
}

.like-btn {
    transition: all 0.3s ease;
}

.like-btn:hover {
    transform: scale(1.1);
}

.like-btn.liked {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.article-actions {
    display: flex;
    align-items: center;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeBtn = document.querySelector('.like-btn');
    
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            const artikelId = this.dataset.artikelId;
            
            fetch(`/artikel/${artikelId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const icon = this.querySelector('i');
                const count = this.querySelector('.like-count');
                
                if (data.liked) {
                    icon.className = 'bi bi-heart-fill';
                    this.classList.add('liked');
                } else {
                    icon.className = 'bi bi-heart';
                    this.classList.remove('liked');
                }
                
                count.textContent = data.total_likes;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memberikan like');
            });
        });
    }
});
</script>
@endsection
@endsection