<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create users
        $admin = User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
        
        $guru = User::create([
            'nama' => 'Guru',
            'username' => 'guru1',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);
        
        $siswa = User::create([
            'nama' => 'Siswa',
            'username' => 'siswa1',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);
        
        // Create categories
        $kategoris = ['Berita Sekolah', 'Prestasi', 'Kegiatan', 'Pengumuman', 'Artikel'];
        
        foreach($kategoris as $kategori) {
            \App\Models\Kategori::create(['nama_kategori' => $kategori]);
        }
        
        // Create sample articles
        \App\Models\Artikel::create([
            'judul' => 'Selamat Datang di Mading Digital',
            'isi' => 'Mading digital adalah platform untuk berbagi informasi dan kreativitas siswa. Platform ini memungkinkan siswa untuk menulis artikel, berbagi prestasi, dan mengumumkan kegiatan sekolah.',
            'tanggal' => now(),
            'id_user' => $admin->id_user,
            'id_kategori' => 1,
            'foto' => null,
            'status' => 'published'
        ]);
        
        \App\Models\Artikel::create([
            'judul' => 'Prestasi Siswa dalam Olimpiade Sains',
            'isi' => 'Siswa-siswi sekolah meraih prestasi gemilang dalam olimpiade sains tingkat nasional. Tim olimpiade sains berhasil meraih medali emas dan perak.',
            'tanggal' => now()->subDays(1),
            'id_user' => $guru->id_user,
            'id_kategori' => 2,
            'foto' => null,
            'status' => 'published'
        ]);
        
        \App\Models\Artikel::create([
            'judul' => 'Kegiatan Ekstrakurikuler Semester Ini',
            'isi' => 'Berbagai kegiatan ekstrakurikuler menarik telah dipersiapkan untuk semester ini. Mulai dari olahraga, seni, hingga teknologi.',
            'tanggal' => now()->subDays(2),
            'id_user' => $siswa->id_user,
            'id_kategori' => 3,
            'foto' => null,
            'status' => 'published'
        ]);
        
        // Create guest user for auto-like
        User::create([
            'nama' => 'Guest User',
            'username' => 'guest_user',
            'email' => 'guest@mading.com',
            'password' => Hash::make('guest123'),
            'role' => 'siswa'
        ]);
        
        // Seed comments
        $this->call(KomentarSeeder::class);
    }
}
