@extends('welcome')

@section('title', 'Pencarian Artikel - Mading Digital')

@section('content')
<!-- Search Header -->
<section id="featured-posts" class="featured-posts section">
  <div class="container section-title" data-aos="fade-up">
    <span class="description-title">Pencarian Artikel</span>
    <h2>
      @if($query)
        Hasil pencarian: "{{ $query }}"
      @else
        Semua Artikel
      @endif
    </h2>
    <p>Temukan artikel yang Anda cari</p>
  </div>

  <!-- Search Form -->
  <div class="container mb-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="search-wrapper p-4 bg-light rounded shadow-sm">
          <form action="{{ route('artikel.index') }}" method="GET" class="search-form">
            <div class="row g-3 align-items-end">
              <div class="col-md-5">
                <label class="form-label fw-bold">Kata Kunci</label>
                <input type="text" name="q" value="{{ $query }}" placeholder="Masukkan kata kunci..." class="form-control form-control-lg">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">Kategori</label>
                <select name="kategori" class="form-control form-control-lg">
                  <option value="">Semua Kategori</option>
                  @foreach($kategoris as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ $kategori == $kat->id_kategori ? 'selected' : '' }}>
                      {{ $kat->nama_kategori }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                  <i class="bi bi-search me-2"></i>Cari
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Articles Grid -->
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      @forelse($artikel as $item)
      <div class="col-md-6 col-lg-4">
        <article class="blog-card">
          <div class="blog-image">
            <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/img/blog/blog-post-square-3.webp') }}" alt="{{ $item->judul }}" loading="lazy">
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
              <div class="d-flex justify-content-between align-items-center">
                <div class="article-stats">
                  <small class="text-muted me-3">
                    <i class="bi bi-heart text-danger"></i> {{ $item->likes->count() }}
                  </small>

                </div>
                <div class="d-flex gap-2">
                  <a href="{{ route('artikel.detail', $item->id_artikel) }}" class="btn-read-more flex-grow-1">
                    <span>Baca Selengkapnya</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </article>
      </div>
      @empty
      <div class="col-12">
        <div class="text-center py-5">
          <div class="empty-state">
            <i class="bi bi-search display-1 text-muted mb-3"></i>
            <h4 class="text-muted">Tidak ada artikel yang ditemukan</h4>
            <p class="text-muted">Coba gunakan kata kunci yang berbeda atau pilih kategori lain</p>
            <a href="{{ route('artikel.index') }}" class="btn btn-outline-primary mt-3">
              <i class="bi bi-arrow-left me-2"></i>Lihat Semua Artikel
            </a>
          </div>
        </div>
      </div>
      @endforelse
    </div>

    @if($artikel->hasPages())
    <div class="d-flex justify-content-center py-5">
      <div class="pagination-wrapper">
        {{ $artikel->links() }}
      </div>
    </div>
    @endif
    
    <!-- Results Info -->
    @if($artikel->count() > 0)
    <div class="container mt-4">
      <div class="row">
        <div class="col-12">
          <div class="results-info text-center text-muted">
            <small>
              Menampilkan {{ $artikel->firstItem() }} - {{ $artikel->lastItem() }} 
              dari {{ $artikel->total() }} artikel
              @if($query || $kategori)
                | <a href="{{ route('artikel.index') }}" class="text-decoration-none">Reset Pencarian</a>
              @endif
            </small>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</section>
@endsection