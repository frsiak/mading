@extends('guru.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="{{ route('guru.verifikasi') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Verifikasi
                </a>
            </div>
            
            <article class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-{{ $artikel->status === 'published' ? 'success' : ($artikel->status === 'draft' ? 'warning' : 'danger') }} fs-6">
                            {{ ucfirst($artikel->status) }}
                        </span>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y, H:i') }}</small>
                    </div>
                    
                    <h1 class="mb-3">{{ $artikel->judul }}</h1>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <i class="bi bi-person-circle fs-4 text-primary"></i>
                        </div>
                        <div>
                            <strong>{{ $artikel->user->nama }}</strong><br>
                            <small class="text-muted">{{ ucfirst($artikel->user->role) }}</small>
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
        </div>
        
        <div class="col-md-4">
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
                            <td>Status</td>
                            <td>
                                <span class="badge bg-{{ $artikel->status === 'published' ? 'success' : ($artikel->status === 'draft' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($artikel->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Admin</td>
                            <td>{{ $artikel->verified_by_admin ? 'Approved' : 'Pending' }}</td>
                        </tr>
                        <tr>
                            <td>Guru</td>
                            <td>{{ $artikel->verified_by_guru ? 'Approved' : 'Pending' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if($artikel->status === 'draft' && !$artikel->verified_by_guru)
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="bi bi-check-circle me-2"></i>Verifikasi</h6>
                    <div class="d-grid gap-2">
                        <form action="{{ route('guru.approve', $artikel->id_artikel) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-lg me-1"></i>Setujui
                            </button>
                        </form>
                        <form action="{{ route('guru.reject', $artikel->id_artikel) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menolak artikel ini?')">
                                <i class="bi bi-x-lg me-1"></i>Tolak
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@section('styles')
<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    text-align: justify;
}
</style>
@endsection
@endsection