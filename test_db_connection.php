<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Artikel;
use App\Models\User;
use App\Models\Kategori;

echo "Test Database Connection:\n";
echo "========================\n";

try {
    // Test koneksi
    $connection = \DB::connection();
    echo "✓ Database connected successfully\n";
    echo "Database path: " . $connection->getDatabaseName() . "\n\n";
    
    // Test buat artikel baru
    echo "Testing create artikel...\n";
    
    $user = User::where('role', 'siswa')->first();
    $kategori = Kategori::first();
    
    if (!$user) {
        echo "✗ No siswa user found\n";
        return;
    }
    
    if (!$kategori) {
        echo "✗ No kategori found\n";
        return;
    }
    
    $artikel = Artikel::create([
        'judul' => 'Test Artikel - ' . date('Y-m-d H:i:s'),
        'isi' => 'Ini adalah test artikel untuk memastikan database berfungsi dengan baik.',
        'tanggal' => now(),
        'id_user' => $user->id_user,
        'id_kategori' => $kategori->id_kategori,
        'foto' => null,
        'status' => 'published',
        'verified_by_admin' => true,
        'verified_by_guru' => true
    ]);
    
    echo "✓ Artikel berhasil dibuat dengan ID: " . $artikel->id_artikel . "\n";
    
    // Cek total artikel
    $total = Artikel::count();
    echo "✓ Total artikel di database: " . $total . "\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}