@extends('welcome')

@section('title', 'Edit Artikel - Guru')

@section('content')
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
                        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Artikel</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guru.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Artikel</label>
                                        <input type="text" name="judul" class="form-control" value="{{ $artikel->judul }}" required>
                                        @error('judul')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="id_kategori" class="form-control" required>
                                            @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id_kategori }}" {{ $artikel->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('id_kategori')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    @if($artikel->foto)
                                    <div class="mb-3">
                                        <label class="form-label">Foto Saat Ini</label><br>
                                        <img src="{{ asset('storage/' . $artikel->foto) }}" alt="Current" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Ganti Foto (Opsional)</label>
                                        <input type="file" name="foto" class="form-control" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                        @error('foto')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Isi Artikel</label>
                                        <textarea name="isi" class="form-control" rows="15" required>{{ $artikel->isi }}</textarea>
                                        @error('isi')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check me-1"></i>Update Artikel
                                        </button>
                                        <a href="{{ route('guru.kelola') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left me-1"></i>Kembali
                                        </a>
                                        <a href="{{ route('artikel.detail', $artikel->id_artikel) }}" class="btn btn-outline-info">
                                            <i class="bi bi-eye me-1"></i>Lihat Artikel
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6><i class="bi bi-info-circle me-2"></i>Info Artikel</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td>Status:</td>
                                                    <td>
                                                        @if($artikel->status == 'published')
                                                        <span class="badge bg-success">Published</span>
                                                        @elseif($artikel->status == 'draft')
                                                        <span class="badge bg-warning">Draft</span>
                                                        @else
                                                        <span class="badge bg-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal:</td>
                                                    <td>{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kategori:</td>
                                                    <td>{{ $artikel->kategori->nama_kategori }}</td>
                                                </tr>
                                            </table>
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