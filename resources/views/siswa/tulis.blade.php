@extends('welcome')

@section('styles')
<style>
/* Header background sama dengan footer */
.header {
    background-color: #f0f1f2 !important;
    border-bottom: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
}

.write-article-form {
    background: var(--surface-color);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.write-article-form::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, color-mix(in srgb, var(--accent-color), transparent 90%) 0%, transparent 70%);
    z-index: 0;
}

.form-content {
    position: relative;
    z-index: 1;
}

.form-floating {
    margin-bottom: 1.5rem;
}

.form-floating .form-control {
    border-radius: 12px;
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    padding: 1.5rem 1.25rem 0.75rem;
    height: calc(3.5rem + 2px);
    background-color: var(--surface-color);
    transition: all 0.3s ease;
}

.form-floating .form-control:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 4px color-mix(in srgb, var(--accent-color), transparent 85%);
    transform: translateY(-2px);
}

.form-floating label {
    color: color-mix(in srgb, var(--default-color), transparent 40%);
    font-weight: 500;
}

.form-floating textarea.form-control {
    height: 200px;
    resize: vertical;
}

.file-upload-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
    margin-bottom: 1.5rem;
}

.file-upload-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 2rem;
    border: 2px dashed color-mix(in srgb, var(--accent-color), transparent 60%);
    border-radius: 12px;
    background: color-mix(in srgb, var(--accent-color), transparent 95%);
    color: var(--accent-color);
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-upload-label:hover {
    border-color: var(--accent-color);
    background: color-mix(in srgb, var(--accent-color), transparent 90%);
    transform: translateY(-2px);
}

.file-upload-label i {
    font-size: 2rem;
}

.btn-submit {
    background: linear-gradient(135deg, var(--accent-color), color-mix(in srgb, var(--accent-color), #1a4372 30%));
    color: var(--contrast-color);
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 auto;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px color-mix(in srgb, var(--accent-color), transparent 70%);
    color: var(--contrast-color);
}

.tips-sidebar {
    background: linear-gradient(135deg, var(--accent-color), color-mix(in srgb, var(--accent-color), #1a4372 40%));
    color: var(--contrast-color);
    border-radius: 20px;
    padding: 2.5rem;
    height: fit-content;
    position: sticky;
    top: 100px;
}

.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    transition: transform 0.3s ease;
}

.tip-item:hover {
    transform: translateX(5px);
}

.tip-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.tip-icon i {
    font-size: 1.5rem;
    color: var(--contrast-color);
}

.tip-content h5 {
    color: var(--contrast-color);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.tip-content p {
    margin: 0;
    opacity: 0.9;
    line-height: 1.5;
}

.back-btn {
    background: rgba(255, 255, 255, 0.2);
    color: var(--contrast-color);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    color: var(--contrast-color);
    transform: translateY(-2px);
}

@media (max-width: 991px) {
    .tips-sidebar {
        margin-top: 2rem;
        position: static;
    }
    
    .write-article-form {
        padding: 2rem;
    }
}
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="page-title">
	<div class="heading">
		<div class="container">
			<div class="row d-flex justify-content-center text-center">
				<div class="col-lg-8">
					<h1><i class="bi bi-pencil-square me-3"></i>Tulis Artikel Baru</h1>
					<p class="mb-0">Bagikan ide dan kreativitas Anda dengan komunitas mading digital</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Form Section -->
<section class="section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="write-article-form">
					<div class="form-content">
						<div class="mb-4">
							<h3 class="mb-2"><i class="bi bi-magic me-2"></i>Mulai Berkarya</h3>
							<p class="text-muted">Tulis artikel yang menginspirasi dan berbagi pengetahuan dengan teman-teman</p>
						</div>
						
						<form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							
							<div class="form-floating">
								<input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Artikel" required>
								<label for="judul"><i class="bi bi-type me-2"></i>Judul Artikel</label>
							</div>
							
							<div class="form-floating">
								<select class="form-control" id="kategori" name="id_kategori" required>
									<option value="">Pilih Kategori</option>
									@foreach($kategoris as $kategori)
										<option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
									@endforeach
								</select>
								<label for="kategori"><i class="bi bi-tags me-2"></i>Kategori</label>
							</div>
							
							<div class="form-floating">
								<textarea class="form-control" id="isi" name="isi" placeholder="Tulis isi artikel di sini..." required></textarea>
								<label for="isi"><i class="bi bi-file-text me-2"></i>Isi Artikel</label>
							</div>
							
							<div class="file-upload-wrapper">
								<input type="file" class="file-upload-input" id="foto" name="foto" accept="image/*">
								<label for="foto" class="file-upload-label">
									<i class="bi bi-cloud-upload"></i>
									<div>
										<strong>Upload Foto Artikel</strong>
										<p class="mb-0 small">Klik atau drag & drop gambar di sini (opsional)</p>
									</div>
								</label>
							</div>
							
							<button type="submit" class="btn-submit">
								<i class="bi bi-send"></i>
								<span>Publikasikan Artikel</span>
							</button>
						</form>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4">
				<div class="tips-sidebar">
					<h4 class="mb-4"><i class="bi bi-lightbulb me-2"></i>Tips Menulis Artikel</h4>
					
					<div class="tip-item">
						<div class="tip-icon">
							<i class="bi bi-bullseye"></i>
						</div>
						<div class="tip-content">
							<h5>Judul Menarik</h5>
							<p>Buat judul yang singkat, jelas, dan menarik perhatian pembaca</p>
						</div>
					</div>
					
					<div class="tip-item">
						<div class="tip-icon">
							<i class="bi bi-bookmark-check"></i>
						</div>
						<div class="tip-content">
							<h5>Pilih Kategori</h5>
							<p>Pilih kategori yang tepat agar artikel mudah ditemukan</p>
						</div>
					</div>
					
					<div class="tip-item">
						<div class="tip-icon">
							<i class="bi bi-image"></i>
						</div>
						<div class="tip-content">
							<h5>Tambah Gambar</h5>
							<p>Gambar membuat artikel lebih menarik dan mudah dipahami</p>
						</div>
					</div>
					
					<div class="tip-item">
						<div class="tip-icon">
							<i class="bi bi-check2-circle"></i>
						</div>
						<div class="tip-content">
							<h5>Periksa Kembali</h5>
							<p>Baca ulang artikel sebelum dipublikasikan</p>
						</div>
					</div>
					
					<div class="text-center mt-4">
						<a href="{{ route('siswa.dashboard') }}" class="back-btn">
							<i class="bi bi-arrow-left"></i>
							<span>Kembali ke Dashboard</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview
    const fileInput = document.getElementById('foto');
    const fileLabel = document.querySelector('.file-upload-label');
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileLabel.innerHTML = `
                <i class="bi bi-check-circle-fill"></i>
                <div>
                    <strong>File terpilih: ${file.name}</strong>
                    <p class="mb-0 small">Klik untuk mengganti gambar</p>
                </div>
            `;
            fileLabel.style.background = 'color-mix(in srgb, #22c55e, transparent 90%)';
            fileLabel.style.borderColor = '#22c55e';
            fileLabel.style.color = '#22c55e';
        }
    });
    
    // Form validation enhancement
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#22c55e';
            }
        });
    });
});
</script>
@endsection