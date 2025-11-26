@extends('admin.layout')

@section('title', 'Laporan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Laporan Sistem</h2>
    <div>
        <a href="{{ route('admin.laporan.pdf') }}" class="btn btn-danger me-2">
            <i class="bi bi-file-pdf"></i> Export PDF
        </a>
        <button class="btn btn-success" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>{{ $stats['total_user'] }}</h4>
                    <p>Total User</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>{{ $stats['total_artikel'] }}</h4>
                    <p>Total Artikel</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h4>{{ $stats['artikel_published'] }}</h4>
                    <p>Artikel Published</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>{{ $stats['artikel_draft'] }}</h4>
                    <p>Artikel Draft</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h4>{{ $stats['user_admin'] }}</h4>
                    <p>Total Admin</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h4>{{ date('d M Y') }}</h4>
                    <p>Tanggal Laporan</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>User per Role</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4 class="text-danger">{{ $stats['user_admin'] }}</h4>
                            <p>Admin</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-primary">{{ $stats['user_guru'] }}</h4>
                            <p>Guru</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-success">{{ $stats['user_siswa'] }}</h4>
                            <p>Siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Ringkasan Laporan</h3>
                </div>
                <div class="card-body">
                    <p><strong>Tanggal Laporan:</strong> {{ date('d F Y') }}</p>
                    <p><strong>Total User:</strong> {{ $stats['total_user'] }} (Admin: {{ $stats['user_admin'] }}, Guru: {{ $stats['user_guru'] }}, Siswa: {{ $stats['user_siswa'] }})</p>
                    <p><strong>Total Artikel:</strong> {{ $stats['total_artikel'] }} (Published: {{ $stats['artikel_published'] }}, Draft: {{ $stats['artikel_draft'] }})</p>
                    <p><strong>Status Sistem:</strong> Berjalan Normal</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .navbar, .sidebar { display: none !important; }
    .container-fluid { margin: 0 !important; padding: 0 !important; }
}
</style>
@endsection