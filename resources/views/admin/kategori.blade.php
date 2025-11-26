@extends('admin.layout')

@section('title', 'Kelola Kategori')

@section('content')
<h2>Kelola Kategori</h2>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Tambah Kategori Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.store-kategori') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Kategori</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Artikel</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoris as $kategori)
                            <tr>
                                <td>{{ $kategori->id_kategori }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $kategori->artikel_count }} artikel</span>
                                </td>
                                <td>
                                    {{ $kategori->created_at->format('d M Y') }}
                                    @if($kategori->artikel_count == 0)
                                        <form method="POST" action="{{ route('admin.delete-kategori', $kategori->id_kategori) }}" class="d-inline ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection