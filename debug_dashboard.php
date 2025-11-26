<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Artikel;

echo "Debug Dashboard Query:\n";
echo "====================\n";

// Query yang sama seperti di controller
$artikelTerbaru = Artikel::with(['user', 'kategori'])
    ->where('status', 'published')
    ->orderBy('id_artikel', 'desc')
    ->limit(6)
    ->get();

echo "Jumlah artikel yang diambil: " . $artikelTerbaru->count() . "\n\n";

foreach($artikelTerbaru as $artikel) {
    echo "ID: {$artikel->id_artikel}\n";
    echo "Judul: {$artikel->judul}\n";
    echo "Status: {$artikel->status}\n";
    echo "User: {$artikel->user->nama}\n";
    echo "Kategori: {$artikel->kategori->nama_kategori}\n";
    echo "Tanggal: {$artikel->tanggal}\n";
    echo "---\n";
}