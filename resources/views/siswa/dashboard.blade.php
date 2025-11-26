{{-- Dashboard Siswa - Halaman utama untuk siswa setelah login --}}
{{-- Extends dari layout welcome yang berisi struktur dasar website --}}
@extends('welcome')

{{-- Custom styles khusus untuk dashboard siswa --}}
@section('styles')
<style>
/* Header background sama dengan footer untuk konsistensi visual */
.header {
    background-color: #f0f1f2 !important;
    border-bottom: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
}

/* Styling untuk section statistik dengan gradient background */
.dashboard-stats {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
}

/* Card statistik dengan efek glass morphism */
.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

/* Styling untuk card artikel dengan efek hover yang smooth */
.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

/* Efek hover untuk memberikan feedback visual saat cursor di atas card */
.blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

/* Badge kategori dengan animasi pulse untuk menarik perhatian */
.category-badge {
    animation: pulse 2s infinite;
}

/* Keyframe untuk animasi pulse yang memberikan efek berkedip halus */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
@endsection

{{-- Konten utama dashboard siswa --}}
@section('content')
{{-- Hero Section - Header halaman dengan sambutan untuk siswa --}}
<section class="page-title">
	<div class="heading">
		<div class="container">
			<div class="row d-flex justify-content-center text-center">
				<div class="col-lg-8">
					{{-- Judul halaman dashboard --}}
					<h1>Dashboard Siswa</h1>
					{{-- Pesan sambutan dengan nama user yang login --}}
					<p class="mb-0">Selamat datang {{ Auth::check() ? Auth::user()->nama : 'Guest' }} - Mari berkarya dengan menulis!</p>
				</div>
			</div>
		</div>
	</div>
</section>

{{-- Stats Section - Menampilkan statistik dan menu cepat untuk siswa --}}
<section class="featured-posts section">
	<div class="container">
		{{-- Menampilkan pesan sukses jika ada dari session --}}
		@if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
		@endif
		
		{{-- Grid layout untuk menampilkan 3 card utama --}}
		<div class="row gy-4">
			{{-- Card 1: Statistik artikel siswa --}}
			<div class="col-md-4">
				<article class="blog-card">
					<div class="blog-image">
						<img src="{{ asset('assets/img/blog/blog-post-square-1.webp') }}" alt="" loading="lazy">
						<div class="category-badge">Statistik</div>
					</div>
					<div class="blog-content">
						<h3>Artikel Saya</h3>
						{{-- Menampilkan jumlah artikel yang ditulis siswa --}}
						<h2 class="text-primary">{{ $artikelSaya }}</h2>
						<p>Total artikel yang telah ditulis</p>
					</div>
				</article>
			</div>
			{{-- Card 2: Menu cepat untuk menulis artikel baru --}}
			<div class="col-md-4">
				<article class="blog-card">
					<div class="blog-image">
						<img src="{{ asset('assets/img/blog/blog-post-square-2.webp') }}" alt="" loading="lazy">
						<div class="category-badge">Menu Cepat</div>
					</div>
					<div class="blog-content">
						<h3>Tulis Artikel</h3>
						<p>Mulai menulis artikel baru</p>
						<div class="blog-footer">
							{{-- Link ke halaman tulis artikel --}}
							<a href="{{ route('siswa.tulis') }}" class="btn-read-more">
								<span>Tulis Sekarang</span>
								<i class="bi bi-arrow-right"></i>
							</a>
						</div>
					</div>
				</article>
			</div>
			{{-- Card 3: Menu untuk mengelola artikel yang sudah ditulis --}}
			<div class="col-md-4">
				<article class="blog-card">
					<div class="blog-image">
						<img src="{{ asset('assets/img/blog/blog-post-square-3.webp') }}" alt="" loading="lazy">
						<div class="category-badge">Kelola</div>
					</div>
					<div class="blog-content">
						<h3>Kelola Artikel</h3>
						<p>Edit dan kelola artikel Anda</p>
						<div class="blog-footer">
							{{-- Link ke halaman kelola artikel --}}
							<a href="{{ route('siswa.kelola') }}" class="btn-read-more">
								<span>Lihat Semua</span>
								<i class="bi bi-arrow-right"></i>
							</a>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>

{{-- Section Artikel Terbaru - Menampilkan artikel terbaru dari semua user --}}
<section class="featured-posts section">
	{{-- Header section dengan animasi AOS --}}
	<div class="container section-title" data-aos="fade-up">
		<span class="description-title">Artikel Terbaru</span>
		<h2>Informasi Terkini</h2>
		<p>Lihat artikel terbaru dari seluruh komunitas</p>
	</div>
	
	{{-- Container untuk grid artikel dengan animasi delay --}}
	<div class="container" data-aos="fade-up" data-aos-delay="100">
		<div class="row gy-4">
			{{-- Loop untuk menampilkan setiap artikel terbaru --}}
			@foreach($artikelTerbaru as $artikel)
			<div class="col-md-6 col-lg-4">
				<article class="blog-card">
					<div class="blog-image">
						{{-- Menampilkan foto artikel atau gambar default jika tidak ada --}}
						<img src="{{ $artikel->foto ? asset('storage/' . $artikel->foto) : asset('assets/img/blog/blog-post-square-3.webp') }}" alt="{{ $artikel->judul }}" loading="lazy">
						{{-- Badge kategori artikel --}}
						<div class="category-badge">{{ $artikel->kategori->nama_kategori }}</div>
					</div>
					<div class="blog-content">
						{{-- Informasi penulis dan tanggal publikasi --}}
						<div class="author-info">
							<div class="author-details">
								<span class="author-name">{{ $artikel->user->nama }}</span>
								{{-- Format tanggal menggunakan Carbon --}}
								<span class="publish-date">{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}</span>
							</div>
						</div>
						{{-- Judul artikel dengan link ke detail --}}
						<h3><a href="{{ route('artikel.detail', $artikel->id_artikel) }}">{{ $artikel->judul }}</a></h3>
						{{-- Preview isi artikel (100 karakter pertama) --}}
						<p>{{ Str::limit(strip_tags($artikel->isi), 100) }}</p>
						<div class="blog-footer">
							{{-- Link untuk membaca artikel lengkap --}}
							<a href="{{ route('artikel.detail', $artikel->id_artikel) }}" class="btn-read-more">
								<span>Baca Selengkapnya</span>
								<i class="bi bi-arrow-right"></i>
							</a>
						</div>
					</div>
				</article>
			</div>
			@endforeach
		</div>
		
		{{-- Action buttons untuk navigasi cepat --}}
		<div class="row mt-4">
			<div class="col-12 text-center">
				{{-- Tombol untuk menulis artikel baru --}}
				<a href="{{ route('siswa.tulis') }}" class="btn btn-primary me-2">Tulis Artikel Baru</a>
				{{-- Tombol untuk mengelola artikel siswa --}}
				<a href="{{ route('siswa.kelola') }}" class="btn btn-outline-primary me-2">Kelola Artikel</a>
				{{-- Tombol untuk membaca artikel --}}
				<a href="{{ route('siswa.baca') }}" class="btn btn-success me-2">Baca Artikel</a>
				{{-- Tombol untuk melihat semua artikel --}}
				<a href="{{ route('artikel.index') }}" class="btn btn-outline-secondary">Lihat Semua Artikel</a>
			</div>
		</div>
	</div>
</section>
@endsection

{{-- JavaScript khusus untuk dashboard siswa --}}
@section('scripts')
<script>
// Dashboard interactivity - Menambahkan interaksi dan animasi
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters - Animasi untuk angka statistik
    const counters = document.querySelectorAll('.text-primary');
    counters.forEach(counter => {
        const target = parseInt(counter.textContent);
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 20);
    });

    // Add click effects to cards - Membuat seluruh card dapat diklik
    const cards = document.querySelectorAll('.blog-card');
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Cek apakah yang diklik bukan link langsung
            if (!e.target.closest('a')) {
                const link = this.querySelector('.btn-read-more');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });

    // Success message auto-hide - Menyembunyikan pesan sukses otomatis
    const alert = document.querySelector('.alert-success');
    if (alert) {
        // Sembunyikan setelah 3 detik
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 3000);
    }
});
</script>
@endsection