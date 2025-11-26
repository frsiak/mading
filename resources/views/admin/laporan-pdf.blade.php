<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mading Digital</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .stats { margin-bottom: 20px; }
        .stats table { width: 100%; border-collapse: collapse; }
        .stats th, .stats td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .stats th { background-color: #f2f2f2; }
        .section { margin-bottom: 30px; }
        h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN MADING DIGITAL</h1>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <div class="section">
        <h2>Statistik Umum</h2>
        <div class="stats">
            <table>
                <tr><th>Metrik</th><th>Jumlah</th></tr>
                <tr><td>Total User</td><td>{{ $stats['total_user'] }}</td></tr>
                <tr><td>Total Artikel</td><td>{{ $stats['total_artikel'] }}</td></tr>
                <tr><td>Artikel Published</td><td>{{ $stats['artikel_published'] }}</td></tr>
                <tr><td>Artikel Draft</td><td>{{ $stats['artikel_draft'] }}</td></tr>
                <tr><td>Artikel Rejected</td><td>{{ $stats['artikel_rejected'] }}</td></tr>
                <tr><td>Total Likes</td><td>{{ $stats['total_likes'] }}</td></tr>
            </table>
        </div>
    </div>

    <div class="section">
        <h2>User per Role</h2>
        <div class="stats">
            <table>
                <tr><th>Role</th><th>Jumlah</th></tr>
                <tr><td>Admin</td><td>{{ $stats['user_admin'] }}</td></tr>
                <tr><td>Guru</td><td>{{ $stats['user_guru'] }}</td></tr>
                <tr><td>Siswa</td><td>{{ $stats['user_siswa'] }}</td></tr>
            </table>
        </div>
    </div>

    <div class="section">
        <h2>Artikel per Kategori</h2>
        <div class="stats">
            <table>
                <tr><th>Kategori</th><th>Jumlah Artikel</th></tr>
                @foreach($artikelPerKategori as $kategori)
                <tr>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->artikel_count }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="section">
        <h2>10 Artikel Terbaru</h2>
        <div class="stats">
            <table>
                <tr><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Tanggal</th><th>Status</th></tr>
                @foreach($artikelTerbaru as $artikel)
                <tr>
                    <td>{{ $artikel->judul }}</td>
                    <td>{{ $artikel->user->nama }}</td>
                    <td>{{ $artikel->kategori->nama_kategori }}</td>
                    <td>{{ date('d/m/Y', strtotime($artikel->tanggal)) }}</td>
                    <td>{{ ucfirst($artikel->status) }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>