@extends('welcome')

@section('title', $artikel->judul . ' - Mading Digital')

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
                            <a href="{{ route('artikel.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>Kembali ke Artikel
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
                                    <i class="bi bi-heart"></i>
                                    <span class="like-count">{{ $artikel->likes ? $artikel->likes->count() : 0 }}</span>
                                </button>
                                
                                <span class="ms-3 text-muted">
                                    <i class="bi bi-chat"></i>
                                    {{ $artikel->komentar ? $artikel->komentar->count() : 0 }} komentar
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
                            <i class="bi bi-chat-dots me-2"></i>Komentar ({{ $artikel->komentar ? $artikel->komentar->count() : 0 }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @auth
                        <!-- Form Komentar untuk user yang login -->
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
                        @else
                        <!-- Pesan untuk guest user -->
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="alert-link">Login</a> untuk memberikan komentar pada artikel ini.
                        </div>
                        @endauth

                        <!-- Daftar Komentar -->
                        @if($artikel->komentar && $artikel->komentar->count() > 0)
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
                                                    @auth
                                                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'guru' || Auth::user()->id_user === $komentar->id_user)
                                                    <form action="{{ route('comment.delete', $komentar->id_komentar) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @endauth
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
                <!-- Info Artikel -->
                <div class="card">
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
                                <td>Likes</td>
                                <td>{{ $artikel->likes ? $artikel->likes->count() : 0 }} suka</td>
                            </tr>
                            <tr>
                                <td>Komentar</td>
                                <td>{{ $artikel->komentar ? $artikel->komentar->count() : 0 }} komentar</td>
                            </tr>

                        </table>
                    </div>
                </div>
                
                <!-- Download -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6><i class="bi bi-download me-2"></i>Download Artikel</h6>
                        <a href="{{ route('artikel.download', $artikel->id_artikel) }}" class="btn btn-success btn-sm w-100">
                            <i class="bi bi-file-earmark-pdf me-1"></i>Download PDF
                        </a>
                    </div>
                </div>
                
                <!-- Share -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6><i class="bi bi-share me-2"></i>Bagikan Artikel</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($artikel->judul) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . request()->fullUrl()) }}" target="_blank" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
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
.alert-link {
    font-weight: bold;
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
            console.log('Clicking like for article:', artikelId);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('CSRF token not found');
                return;
            }
            
            fetch(`/artikel/${artikelId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (response.status === 419) {
                    alert('Session expired. Silakan refresh halaman dan coba lagi.');
                    window.location.reload();
                    return Promise.reject('CSRF token mismatch');
                }
                
                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Error response body:', text);
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data && data.total_likes !== undefined) {
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
                    
                    if (data.message) {
                        console.log(data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memberikan like: ' + error.message);
            });
        });
    }
});
</script>
@endsection
@endsection