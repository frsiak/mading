@extends('welcome')

@section('title', 'Verifikasi Artikel - Guru')

@section('content')
<section class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1><i class="bi bi-check-circle me-3"></i>Verifikasi Artikel</h1>
                    <p class="mb-0">Review dan setujui artikel dari siswa</p>
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
                        <h5><i class="bi bi-list-ul me-2"></i>Menu Guru</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('guru.dashboard') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                            <a href="{{ route('guru.tulis') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-pencil me-2"></i>Tulis Artikel
                            </a>
                            <a href="{{ route('guru.kelola') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-folder me-2"></i>Kelola Artikel
                            </a>
                            <a href="{{ route('guru.verifikasi') }}" class="list-group-item list-group-item-action active">
                                <i class="bi bi-check-circle me-2"></i>Verifikasi Artikel
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
                        <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Verifikasi Artikel Siswa</h5>
                        <small class="text-muted">Artikel yang menunggu persetujuan dari siswa</small>
                    </div>
                    <div class="card-body">
                        @if($artikel->count() > 0)
                            @foreach($artikel as $item)
                            <div class="card mb-3 border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="img-fluid rounded">
                                            @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px;">
                                                <i class="bi bi-image text-muted fs-1"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            <h6 class="card-title">{{ $item->judul }}</h6>
                                            <p class="card-text">{{ Str::limit(strip_tags($item->isi), 150) }}</p>
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="bi bi-person me-1"></i>
                                                <span class="me-3">{{ $item->user->nama }}</span>
                                                <i class="bi bi-tag me-1"></i>
                                                <span class="me-3">{{ $item->kategori->nama_kategori }}</span>
                                                <i class="bi bi-calendar me-1"></i>
                                                <span class="me-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y, H:i') }}</span>
                                                <span class="badge bg-{{ $item->status == 'published' ? 'success' : ($item->status == 'draft' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <span class="badge bg-{{ $item->verified_by_admin ? 'success' : 'secondary' }} me-1">
                                                    Admin: {{ $item->verified_by_admin ? 'OK' : 'Pending' }}
                                                </span>
                                                <span class="badge bg-{{ $item->verified_by_guru ? 'success' : 'secondary' }}">
                                                    Guru: {{ $item->verified_by_guru ? 'OK' : 'Pending' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('guru.detail', $item->id_artikel) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye me-1"></i>Lihat Detail
                                                </a>
                                                @if(!$item->verified_by_guru && $item->status == 'draft')
                                                <form action="{{ route('guru.approve', $item->id_artikel) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm w-100" onclick="return confirm('Setujui artikel ini?')">
                                                        <i class="bi bi-check me-1"></i>Setujui
                                                    </button>
                                                </form>
                                                @endif
                                                @if($item->status == 'draft')
                                                <form action="{{ route('guru.reject', $item->id_artikel) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Tolak artikel ini?')">
                                                        <i class="bi bi-x me-1"></i>Tolak
                                                    </button>
                                                </form>
                                                @endif
                                                @if($item->verified_by_guru)
                                                <small class="text-success">Sudah diverifikasi guru</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            

                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle display-1 text-muted"></i>
                                <h5 class="text-muted mt-3">Tidak ada artikel yang perlu diverifikasi</h5>
                                <p class="text-muted">Semua artikel siswa sudah diverifikasi atau belum ada artikel baru</p>
                                <a href="{{ route('guru.kelola') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-folder me-1"></i>Lihat Semua Artikel
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection