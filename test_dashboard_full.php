<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Artikel;
use App\Models\User;

echo "Test Dashboard Full:\n";
echo "==================\n\n";

// Test 1: Cek semua artikel
echo "1. Semua artikel di database:\n";
$allArtikel = Artikel::with(['user', 'kategori'])->get();
foreach($allArtikel as $artikel) {
    echo "   ID: {$artikel->id_artikel} | Status: {$artikel->status} | Judul: {$artikel->judul}\n";
}

// Test 2: Artikel published saja
echo "\n2. Artikel dengan status published:\n";
$publishedArtikel = Artikel::with(['user', 'kategori'])
    ->where('status', 'published')
    ->orderBy('id_artikel', 'desc')
    ->get();
    
foreach($publishedArtikel as $artikel) {
    echo "   ID: {$artikel->id_artikel} | User: {$artikel->user->nama} | Kategori: {$artikel->kategori->nama_kategori} | Judul: {$artikel->judul}\n";
}

// Test 3: Query exact seperti controller
echo "\n3. Query exact dari controller (dengan limit 6):\n";
$controllerQuery = Artikel::with(['user', 'kategori'])
    ->where('status', 'published')
    ->orderBy('id_artikel', 'desc')
    ->limit(6)
    ->get();
    
echo "   Jumlah hasil: " . $controllerQuery->count() . "\n";
foreach($controllerQuery as $artikel) {
    echo "   ID: {$artikel->id_artikel} | Judul: {$artikel->judul}\n";
}

echo "\n4. Cek user siswa:\n";
$siswa = User::where('role', 'siswa')->first();
if($siswa) {
    echo "   Siswa ditemukan: {$siswa->nama} (ID: {$siswa->id_user})\n";
    $artikelSiswa = Artikel::where('id_user', $siswa->id_user)->count();
    echo "   Artikel siswa: {$artikelSiswa}\n";
} else {
    echo "   Tidak ada user siswa\n";
}