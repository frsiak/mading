@extends('admin.layout')

@section('title', 'Verifikasi Artikel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Verifikasi Artikel</h3>
                    @if($artikel->count() > 0)
                        <span class="badge bg-warning fs-6">
                            <i class="bi bi-exclamation-triangle"></i> {{ $artikel->count() }} artikel menunggu
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artikel as $item)
                                <tr class="table-warning">
                                    <td>
                                        <i class="bi bi-clock text-warning me-2"></i>
                                        {{ $item->judul }}
                                    </td>
                                    <td>{{ $item->user->nama }}</td>
                                    <td>{{ $item->kategori->nama_kategori }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                        <div class="mb-2">
                                            <span class="badge bg-{{ $item->verified_by_admin ? 'success' : 'secondary' }}">
                                                Admin: {{ $item->verified_by_admin ? 'OK' : 'Pending' }}
                                            </span>
                                            <span class="badge bg-{{ $item->verified_by_guru ? 'success' : 'secondary' }}">
                                                Guru: {{ $item->verified_by_guru ? 'OK' : 'Pending' }}
                                            </span>
                                        </div>
                                        @if(!$item->verified_by_admin && $item->status == 'draft')
                                        <form method="POST" action="{{ route('admin.approve', $item->id_artikel) }}" class="d-inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Setujui</button>
                                        </form>
                                        @endif
                                        @if($item->status == 'draft')
                                        <form method="POST" action="{{ route('admin.reject', $item->id_artikel) }}" class="d-inline">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($artikel->count() == 0)
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">Tidak ada artikel yang perlu diverifikasi</h5>
                            <p class="text-muted">Semua artikel sudah disetujui atau ditolak</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection