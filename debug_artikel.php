<?php
// Debug script untuk memeriksa artikel di database
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Artikel;
use App\Models\User;

echo "=== DEBUG ARTIKEL ===\n\n";

// Cek total artikel
$totalArtikel = Artikel::count();
echo "Total artikel: $totalArtikel\n\n";

// Cek artikel berdasarkan status
$artikelDraft = Artikel::where('status', 'draft')->count();
$artikelPublished = Artikel::where('status', 'published')->count();
$artikelRejected = Artikel::where('status', 'rejected')->count();

echo "Artikel draft: $artikelDraft\n";
echo "Artikel published: $artikelPublished\n";
echo "Artikel rejected: $artikelRejected\n\n";

// Tampilkan detail artikel draft
echo "=== DETAIL ARTIKEL DRAFT ===\n";
$draftArtikel = Artikel::with(['user', 'kategori'])
    ->where('status', 'draft')
    ->get();

foreach($draftArtikel as $artikel) {
    echo "ID: {$artikel->id_artikel}\n";
    echo "Judul: {$artikel->judul}\n";
    echo "Penulis: {$artikel->user->nama} ({$artikel->user->role})\n";
    echo "Status: {$artikel->status}\n";
    echo "Admin Verified: " . ($artikel->verified_by_admin ? 'Ya' : 'Tidak') . "\n";
    echo "Guru Verified: " . ($artikel->verified_by_guru ? 'Ya' : 'Tidak') . "\n";
    echo "Tanggal: {$artikel->tanggal}\n";
    echo "---\n";
}

// Cek query yang digunakan admin
echo "\n=== QUERY ADMIN VERIFIKASI ===\n";
$adminQuery = Artikel::with(['user', 'kategori'])
    ->where('status', 'draft')
    ->orderBy('tanggal', 'desc')
    ->get();
echo "Hasil query admin: " . $adminQuery->count() . " artikel\n";

// Cek query yang digunakan guru
echo "\n=== QUERY GURU VERIFIKASI ===\n";
$guruQuery = Artikel::with(['user', 'kategori'])
    ->where('verified_by_guru', false)
    ->where('status', 'draft')
    ->orderBy('tanggal', 'desc')
    ->get();
echo "Hasil query guru: " . $guruQuery->count() . " artikel\n";

echo "\n=== SELESAI ===\n";