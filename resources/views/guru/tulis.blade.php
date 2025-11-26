@extends('welcome')

@section('title', 'Tulis Artikel - Guru')

@section('content')
<section class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1><i class="bi bi-pencil me-3"></i>Tulis Artikel Baru</h1>
                    <p class="mb-0">Bagikan pengetahuan dan pengalaman dengan komunitas</p>
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
                            <a href="{{ route('guru.tulis') }}" class="list-group-item list-group-item-action active">
                                <i class="bi bi-pencil me-2"></i>Tulis Artikel
                            </a>
                            <a href="{{ route('guru.kelola') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-folder me-2"></i>Kelola Artikel
                            </a>
                            <a href="{{ route('guru.verifikasi') }}" class="list-group-item list-group-item-action">
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
                        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Tulis Artikel Baru</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Artikel</label>
                                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul artikel yang menarik..." required>
                                        @error('judul')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="id_kategori" class="form-control" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_kategori')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Foto Artikel (Opsional)</label>
                                        <input type="file" name="foto" class="form-control" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB</small>
                                        @error('foto')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Isi Artikel</label>
                                        <textarea name="isi" class="form-control" rows="15" placeholder="Tulis isi artikel di sini..." required></textarea>
                                        @error('isi')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check me-1"></i>Publikasikan Artikel
                                        </button>
                                        <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left me-1"></i>Kembali
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6><i class="bi bi-lightbulb me-2"></i>Tips Menulis Artikel</h6>
                                            <ul class="small">
                                                <li>Gunakan judul yang menarik dan informatif</li>
                                                <li>Pilih kategori yang sesuai dengan isi artikel</li>
                                                <li>Tambahkan foto untuk mempercantik artikel</li>
                                                <li>Tulis dengan bahasa yang mudah dipahami</li>
                                                <li>Periksa kembali sebelum mempublikasikan</li>
                                            </ul>
                                            
                                            <div class="alert alert-info mt-3">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <strong>Catatan:</strong> Artikel guru akan langsung dipublikasikan tanpa perlu persetujuan.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection