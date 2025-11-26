<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Kategori;
use App\Models\User;
use App\Models\Artikel;

// Buat kategori
Kategori::create(['nama_kategori' => 'Berita Sekolah']);
Kategori::create(['nama_kategori' => 'Prestasi']);
Kategori::create(['nama_kategori' => 'Kegiatan']);

// Buat user
User::create(['nama' => 'Admin', 'username' => 'admin', 'password' => bcrypt('admin123'), 'role' => 'admin']);
User::create(['nama' => 'Guru Bahasa', 'username' => 'guru', 'password' => bcrypt('guru123'), 'role' => 'guru']);
User::create(['nama' => 'Siswa', 'username' => 'siswa', 'password' => bcrypt('siswa123'), 'role' => 'siswa']);

// Buat artikel
Artikel::create([
    'judul' => 'Selamat Datang di Mading Digital',
    'isi' => 'Mading digital adalah platform untuk berbagi informasi dan kreativitas siswa. Platform ini memungkinkan siswa untuk menulis artikel, berbagi pengalaman, dan mengekspresikan ide-ide kreatif mereka dalam format digital yang modern.',
    'tanggal' => now(),
    'id_user' => 1,
    'id_kategori' => 1,
    'foto' => null,
    'status' => 'published'
]);

Artikel::create([
    'judul' => 'Prestasi Siswa dalam Olimpiade Sains',
    'isi' => 'Siswa-siswa sekolah meraih prestasi gemilang dalam olimpiade sains tingkat nasional. Tim olimpiade sains berhasil meraih medali emas dan perak dalam berbagai kategori kompetisi.',
    'tanggal' => now(),
    'id_user' => 2,
    'id_kategori' => 2,
    'foto' => null,
    'status' => 'published'
]);

Artikel::create([
    'judul' => 'Kegiatan Ekstrakurikuler Semester Ini',
    'isi' => 'Berbagai kegiatan ekstrakurikuler menarik telah dipersiapkan untuk semester ini. Mulai dari olahraga, seni, hingga teknologi, semua tersedia untuk mengembangkan bakat dan minat siswa.',
    'tanggal' => now(),
    'id_user' => 3,
    'id_kategori' => 3,
    'foto' => null,
    'status' => 'published'
]);

echo "Data sample berhasil dibuat!\n";