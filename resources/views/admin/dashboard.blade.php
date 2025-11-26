@extends('admin.layout')

@section('styles')
<style>
.header {
    background-color: #f0f1f2 !important;
    border-bottom: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
}

.admin-card {
    background: var(--surface-color);
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    height: 100%;
}

.admin-card:hover {
    transform: translateY(-5px);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--accent-color);
}
</style>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row mb-4">
		<div class="col-12">
			<h2><i class="bi bi-shield-check me-3"></i>Dashboard Admin</h2>
			<p class="text-muted">Selamat datang {{ Auth::user()->nama }} - Kelola sistem mading digital</p>
		</div>
	</div>
		<div class="row mb-4">
			<div class="col-md-3">
				<div class="admin-card text-center">
					<i class="bi bi-people-fill" style="font-size: 3rem; color: var(--accent-color);"></i>
					<h3 class="stat-number mt-3">{{ $totalUser }}</h3>
					<h5>Total User</h5>
					<p class="text-muted">Semua pengguna</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="admin-card text-center">
					<i class="bi bi-file-text-fill" style="font-size: 3rem; color: #28a745;"></i>
					<h3 class="stat-number mt-3" style="color: #28a745;">{{ $totalArtikel }}</h3>
					<h5>Total Artikel</h5>
					<p class="text-muted">Semua artikel</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="admin-card text-center">
					<i class="bi bi-tags-fill" style="font-size: 3rem; color: #17a2b8;"></i>
					<h3 class="stat-number mt-3" style="color: #17a2b8;">{{ $totalKategori }}</h3>
					<h5>Total Kategori</h5>
					<p class="text-muted">Kategori artikel</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="admin-card text-center">
					<i class="bi bi-clock-fill" style="font-size: 3rem; color: #ffc107;"></i>
					<h3 class="stat-number mt-3" style="color: #ffc107;">{{ $artikelPending }}</h3>
					<h5>Artikel Pending</h5>
					<p class="text-muted">Menunggu review</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="admin-card text-center">
					<h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Sistem Mading Digital</h5>
					<p class="text-muted">Dashboard admin untuk mengelola sistem mading digital sekolah. Gunakan menu di bawah untuk mengakses fitur-fitur admin.</p>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-12 text-center">
				<h3 class="mb-4">Menu Admin</h3>
				<div class="row">
					<div class="col-md-2 col-6 mb-3">
						<a href="{{ route('admin.verifikasi') }}" class="btn btn-warning w-100 py-3">
							<i class="bi bi-check-circle d-block mb-2" style="font-size: 2rem;"></i>
							Verifikasi Artikel
						</a>
					</div>
					<div class="col-md-2 col-6 mb-3">
						<a href="{{ route('admin.kategori') }}" class="btn btn-info w-100 py-3">
							<i class="bi bi-tags d-block mb-2" style="font-size: 2rem;"></i>
							Kelola Kategori
						</a>
					</div>
					<div class="col-md-2 col-6 mb-3">
						<a href="{{ route('admin.laporan') }}" class="btn btn-secondary w-100 py-3">
							<i class="bi bi-graph-up d-block mb-2" style="font-size: 2rem;"></i>
							Laporan
						</a>
					</div>
					<div class="col-md-2 col-6 mb-3">
						<form action="{{ route('logout') }}" method="POST" class="d-inline">
							@csrf
							<button type="submit" class="btn btn-danger w-100 py-3">
								<i class="bi bi-box-arrow-right d-block mb-2" style="font-size: 2rem;"></i>
								Logout
							</button>
						</form>
					</div>
				</div>
			</div>
	</div>
</div>
@endsection