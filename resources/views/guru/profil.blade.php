@extends('welcome')

@section('title', 'Profil Guru - Mading Digital')

@section('content')
<section class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1><i class="bi bi-person-circle me-3"></i>Profil Guru</h1>
                    <p class="mb-0">Informasi akun dan pengaturan profil</p>
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

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Nama Lengkap:</strong></td>
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
                                        <td><strong>Bergabung:</strong></td>
                                        <td>{{ Auth::user()->created_at ? Auth::user()->created_at->format('d F Y') : 'Tidak diketahui' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <i class="bi bi-person-circle" style="font-size: 8rem; color: #6c757d;"></i>
                                    <h5 class="mt-3">{{ Auth::user()->nama }}</h5>
                                    <p class="text-muted">Guru Mading Digital</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mt-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Statistik Aktivitas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="text-primary">{{ \App\Models\Artikel::where('id_user', Auth::id())->count() }}</h3>
                                    <p>Total Artikel</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="text-success">{{ \App\Models\Artikel::where('id_user', Auth::id())->where('status', 'published')->count() }}</h3>
                                    <p>Artikel Published</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="text-warning">{{ \App\Models\Artikel::where('status', 'draft')->where('verified_by_guru', false)->count() }}</h3>
                                    <p>Artikel Pending</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('guru.dashboard') }}" class="btn btn-primary me-2">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('guru.tulis') }}" class="btn btn-success">
                        <i class="bi bi-pencil"></i> Tulis Artikel Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.stat-item {
    padding: 20px;
    border-radius: 10px;
    background: #f8f9fa;
    margin-bottom: 20px;
}
.stat-item h3 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 10px;
}
</style>
@endsection