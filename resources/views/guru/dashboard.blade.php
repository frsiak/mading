@extends('welcome')

@section('title', 'Dashboard Guru - Mading Digital')

@section('styles')
<style>
.header {
    background-color: #f0f1f2 !important;
    border-bottom: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
}

.guru-card {
    background: var(--surface-color);
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    height: 100%;
}

.guru-card:hover {
    transform: translateY(-5px);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--accent-color);
}
</style>
@endsection

@section('scripts')
<script>
function logoutUser() {
    if (confirm('Yakin ingin logout?')) {
        // Buat form logout secara dinamis
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('logout') }}';
        
        // Tambahkan CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection

@section('content')
<section class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1><i class="bi bi-mortarboard me-3"></i>Dashboard Guru</h1>
                    <p class="mb-0">Selamat datang {{ Auth::user()->nama }} - Kelola dan verifikasi artikel siswa</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="guru-card text-center">
                    <i class="bi bi-clock-fill" style="font-size: 3rem; color: #ffc107;"></i>
                    <h3 class="stat-number mt-3" style="color: #ffc107;">{{ $artikelPending }}</h3>
                    <h5>Artikel Pending</h5>
                    <p class="text-muted">Menunggu verifikasi</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="guru-card text-center">
                    <i class="bi bi-file-text-fill" style="font-size: 3rem; color: #28a745;"></i>
                    <h3 class="stat-number mt-3" style="color: #28a745;">{{ $artikelSaya }}</h3>
                    <h5>Artikel Saya</h5>
                    <p class="text-muted">Artikel yang saya tulis</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="guru-card text-center">
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: var(--accent-color);"></i>
                    <h3 class="stat-number mt-3">{{ $artikelTerbaru->count() }}</h3>
                    <h5>Artikel Terbaru</h5>
                    <p class="text-muted">Artikel terbaru sistem</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="guru-card">
                    <h5 class="mb-3"><i class="bi bi-file-text me-2"></i>Artikel Terbaru</h5>
                    @if($artikelTerbaru->count() > 0)
                        @foreach($artikelTerbaru as $artikel)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <strong>{{ Str::limit($artikel->judul, 30) }}</strong><br>
                                <small class="text-muted">{{ $artikel->user->nama }} - {{ $artikel->kategori->nama_kategori }}</small>
                            </div>
                            <span class="badge bg-{{ $artikel->status == 'published' ? 'success' : ($artikel->status == 'draft' ? 'warning' : 'danger') }}">
                                {{ ucfirst($artikel->status) }}
                            </span>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Belum ada artikel</p>
                    @endif
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="guru-card">
                    <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Guru</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama:</strong></td>
                            <td>{{ Auth::user()->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Username:</strong></td>
                            <td>{{ Auth::user()->username }}</td>
                        </tr>
                        <tr>
                            <td><strong>Role:</strong></td>
                            <td><span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Login Terakhir:</strong></td>
                            <td>{{ now()->format('d F Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <h3 class="mb-4">Menu Guru</h3>
                <div class="row">
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('guru.tulis') }}" class="btn btn-primary w-100 py-3">
                            <i class="bi bi-pencil d-block mb-2" style="font-size: 2rem;"></i>
                            Tulis Artikel
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('guru.kelola') }}" class="btn btn-success w-100 py-3">
                            <i class="bi bi-folder d-block mb-2" style="font-size: 2rem;"></i>
                            Kelola Artikel
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('guru.verifikasi') }}" class="btn btn-warning w-100 py-3">
                            <i class="bi bi-check-circle d-block mb-2" style="font-size: 2rem;"></i>
                            Verifikasi Artikel
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('artikel.index') }}" class="btn btn-info w-100 py-3">
                            <i class="bi bi-book d-block mb-2" style="font-size: 2rem;"></i>
                            Baca Artikel
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('guru.profil') }}" class="btn btn-secondary w-100 py-3">
                            <i class="bi bi-person d-block mb-2" style="font-size: 2rem;"></i>
                            Profil
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <button type="button" class="btn btn-danger w-100 py-3" onclick="logoutUser()">
                            <i class="bi bi-box-arrow-right d-block mb-2" style="font-size: 2rem;"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection