@extends('welcome')

@section('title', 'Edit Artikel - Siswa')

@section('content')
<section class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1><i class="bi bi-pencil-square me-3"></i>Edit Artikel</h1>
                    <p class="mb-0">Perbaiki dan tingkatkan kualitas artikel Anda</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Form Edit Artikel</h5>
					</div>
					<div class="card-body">
						<form action="{{ route('siswa.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							
							<div class="mb-3">
								<label class="form-label">Judul Artikel</label>
								<input type="text" name="judul" class="form-control" value="{{ $artikel->judul }}" required>
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
							</div>
							
							@if($artikel->foto)
							<div class="mb-3">
								<label class="form-label">Foto Saat Ini</label><br>
								<img src="{{ asset('storage/' . $artikel->foto) }}" alt="Current" class="img-thumbnail" style="max-width: 200px;">
							</div>
							@endif
							
							<div class="mb-3">
								<label class="form-label">Ganti Foto (Opsional)</label>
								<input type="file" name="foto" accept="image/*" class="form-control" id="fotoInput">
								<small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
								<div id="previewContainer" style="display: none; margin-top: 10px;">
									<label class="form-label">Preview Foto Baru</label><br>
									<img id="previewImage" class="img-thumbnail" style="max-width: 200px;">
								</div>
							</div>
							
							<div class="mb-3">
								<label class="form-label">Isi Artikel</label>
								<textarea name="isi" class="form-control" rows="10" required>{{ $artikel->isi }}</textarea>
							</div>
							
							<div class="alert alert-info">
								<i class="bi bi-info-circle me-2"></i>Setelah diupdate, artikel akan direview ulang oleh admin/guru
							</div>
							
							<div class="d-flex gap-2">
								<button type="submit" class="btn btn-primary">
									<i class="bi bi-check me-1"></i>Update Artikel
								</button>
								<a href="{{ route('siswa.kelola') }}" class="btn btn-secondary">
									<i class="bi bi-arrow-left me-1"></i>Kembali
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Artikel</h5>
					</div>
					<div class="card-body">
						<div class="mb-3">
							<strong>Status Artikel:</strong><br>
							@if($artikel->status == 'published')
								<span class="badge bg-success">Published</span>
							@elseif($artikel->status == 'draft')
								<span class="badge bg-warning">Menunggu Persetujuan</span>
							@else
								<span class="badge bg-danger">Ditolak</span>
							@endif
						</div>
						<div class="mb-3">
							<strong>Tanggal Dibuat:</strong><br>
							{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y, H:i') }}
						</div>
						<div class="mb-3">
							<strong>Kategori:</strong><br>
							<span class="badge bg-primary">{{ $artikel->kategori->nama_kategori }}</span>
						</div>
						<div class="d-grid gap-2">
							<a href="{{ route('artikel.detail', $artikel->id_artikel) }}" class="btn btn-outline-primary btn-sm">
								<i class="bi bi-eye me-1"></i>Lihat Artikel
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('previewContainer').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('previewContainer').style.display = 'none';
    }
});
</script>
@endsection