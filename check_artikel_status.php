<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Artikel;

echo "Status artikel di database:\n";
echo "========================\n";

$artikel = Artikel::select('id_artikel', 'judul', 'status', 'verified_by_admin', 'verified_by_guru')->get();

foreach($artikel as $art) {
    echo "ID: {$art->id_artikel} | Status: {$art->status} | Admin: " . ($art->verified_by_admin ? 'Yes' : 'No') . " | Guru: " . ($art->verified_by_guru ? 'Yes' : 'No') . " | Judul: " . substr($art->judul, 0, 50) . "\n";
}

echo "\nTotal artikel: " . $artikel->count() . "\n";
echo "Artikel published: " . Artikel::where('status', 'published')->count() . "\n";