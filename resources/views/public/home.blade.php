@extends('welcome')

@section('title', 'Mading Digital Sekolah')

@section('content')

@if($artikelTerbaru->count() > 0)
@php $featuredArtikel = $artikelTerbaru->first(); @endphp
<section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $featuredArtikel->foto ? asset('uploads/' . $featuredArtikel->foto) : asset('assets/img/blog/blog-hero-1.webp') }}'); background-size: cover; background-position: center; min-height: 100vh; display: flex; align-items: center; position: relative;">
  <div class="container text-center text-white">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="hero-content">
          <div class="category-badge mb-4" style="background: #007bff; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; display: inline-block;">{{ strtoupper($featuredArtikel->kategori->nama_kategori) }}</div>
          <h1 class="display-3 fw-bold mb-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5); line-height: 1.2;">{{ $featuredArtikel->judul }}</h1>
          <div class="hero-meta mb-4" style="font-size: 1.1rem;">
            <span class="me-4" style="opacity: 0.9;">BY {{ $featuredArtikel->user->nama }}</span>
            <span class="me-4" style="opacity: 0.9;">{{ \Carbon\Carbon::parse($featuredArtikel->tanggal)->format('d M, Y') }}</span>
            <span style="opacity: 0.9;">Artikel Populer</span>
          </div>
          <a href="{{ route('artikel.detail', $featuredArtikel->id_artikel) }}" class="btn-hero" style="background: rgba(255,255,255,0.2); border: 2px solid white; color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; display: inline-block;">
            Baca Selengkapnya →
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@else
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; position: relative;">
  <div class="container text-center text-white">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="hero-content">
          <div class="category-badge mb-4" style="background: #007bff; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; display: inline-block;">MADING DIGITAL</div>
          <h1 class="display-3 fw-bold mb-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Selamat Datang di Mading Digital</h1>
          <div class="hero-meta mb-4" style="font-size: 1.1rem;">
            <span class="me-4" style="opacity: 0.9;">Platform Digital Sekolah</span>
            <span class="me-4" style="opacity: 0.9;">{{ date('d M, Y') }}</span>
            <span style="opacity: 0.9;">Mari Berkarya</span>
          </div>
          <a href="{{ route('login') }}" class="btn-hero" style="background: rgba(255,255,255,0.2); border: 2px solid white; color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; display: inline-block;">
            Mulai Menulis →
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endif





<section id="featured-posts" class="featured-posts section py-5">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="badge bg-primary mb-3 px-3 py-2">📚 Artikel Terbaru</span>
      <h2 class="display-5 fw-bold mb-3">Informasi Terkini</h2>
      <p class="lead text-muted">Temukan berbagai informasi menarik dan terkini dari komunitas sekolah</p>
    </div>

    <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
      @forelse($artikelTerbaru as $artikel)
      <div class="col-md-6 col-lg-4">
        <article class="card h-100" style="border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; background: white;">
          <div class="card-image position-relative" style="height: 240px; overflow: hidden;">
            <img src="{{ $artikel->foto ? asset('uploads/' . $artikel->foto) : asset('assets/img/blog/blog-post-square-1.webp') }}" 
                 alt="{{ $artikel->judul }}" 
                 class="w-100 h-100" 
                 style="object-fit: cover;">
          </div>
          <div class="card-body p-4">
            <div class="mb-2">
              <small class="text-muted fw-semibold">{{ $artikel->user->nama }}</small>
              <br><small class="text-muted">{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}</small>
            </div>
            <h5 class="card-title fw-bold mb-3" style="color: #2c3e50; line-height: 1.3;">
              {{ $artikel->judul }}
            </h5>
            <p class="card-text text-muted mb-4" style="font-size: 0.9rem; line-height: 1.5;">
              {{ Str::limit(strip_tags($artikel->isi), 120) }}
            </p>
            <div class="d-flex align-items-center justify-content-between mt-auto">
              <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-outline-danger me-3" style="border-radius: 20px; border: none; background: #f8f9fa;">
                  <i class="bi bi-heart text-danger"></i> {{ $artikel->likes->count() ?? 0 }}
                </button>
                <button class="btn btn-sm" style="border: none; background: #f8f9fa; border-radius: 20px;">
                  <i class="bi bi-chat text-muted"></i> 0
                </button>
              </div>
              <a href="{{ route('artikel.detail', $artikel->id_artikel) }}" class="btn btn-primary" style="border-radius: 25px; padding: 8px 20px; font-weight: 500;">
                BACA SELENGKAPNYA <i class="bi bi-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </article>
      </div>
      @empty
      <div class="col-12">
        <div class="text-center py-5">
          <i class="bi bi-journal-text" style="font-size: 4rem; color: #dee2e6;"></i>
          <h4 class="mt-3 text-muted">Belum Ada Artikel</h4>
          <p class="text-muted">Jadilah yang pertama untuk berbagi cerita!</p>
          <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Menulis</a>
        </div>
      </div>
      @endforelse
    </div>
    
    @if($artikelTerbaru->count() > 0)
    <div class="text-center mt-5">
      <a href="{{ route('artikel.index') }}" class="btn btn-outline-primary btn-lg px-5 py-3" style="border-radius: 25px;">
        <i class="bi bi-grid me-2"></i>Lihat Semua Artikel
      </a>
    </div>
    @endif
  </div>
</section>

<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.card .card-image img {
    transition: transform 0.3s ease;
}

.card:hover .card-image img {
    transform: scale(1.02);
}

.btn-hero:hover {
    background: white !important;
    color: #333 !important;
    text-decoration: none;
}

.hero-section {
    transition: all 0.3s ease;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
}

.card-body {
    display: flex;
    flex-direction: column;
}

.card-body .mt-auto {
    margin-top: auto;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Like button untuk halaman home
    document.querySelectorAll('.like-btn-home').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const artikelId = this.dataset.artikelId;
            
            fetch(`/artikel/${artikelId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = this.querySelector('i');
                    const text = this.childNodes[2];
                    
                    if (data.liked) {
                        icon.className = 'bi bi-heart-fill';
                        this.classList.remove('btn-outline-danger');
                        this.classList.add('btn-danger');
                    } else {
                        icon.className = 'bi bi-heart';
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-outline-danger');
                    }
                    
                    text.textContent = ' ' + data.total_likes;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endsection