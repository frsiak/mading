<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komentar;
use App\Models\Artikel;
use App\Models\User;

class KomentarSeeder extends Seeder
{
    public function run(): void
    {
        // Get published articles
        $artikel = Artikel::where('status', 'published')->get();
        $users = User::all();
        
        if ($artikel->count() > 0 && $users->count() > 0) {
            // Add sample comments to the first published article
            $firstArtikel = $artikel->first();
            
            Komentar::create([
                'id_artikel' => $firstArtikel->id_artikel,
                'id_user' => $users->where('role', 'siswa')->first()->id_user,
                'komentar' => 'Artikel yang sangat menarik! Terima kasih atas informasinya.',
                'tanggal' => now()->subHours(2)
            ]);
            
            Komentar::create([
                'id_artikel' => $firstArtikel->id_artikel,
                'id_user' => $users->where('role', 'guru')->first()->id_user,
                'komentar' => 'Bagus sekali! Semoga platform ini bisa terus berkembang.',
                'tanggal' => now()->subHour()
            ]);
            
            Komentar::create([
                'id_artikel' => $firstArtikel->id_artikel,
                'id_user' => $users->where('role', 'admin')->first()->id_user,
                'komentar' => 'Selamat datang di mading digital! Mari berkarya bersama.',
                'tanggal' => now()->subMinutes(30)
            ]);
            
            // Add comments to second article if exists
            if ($artikel->count() > 1) {
                $secondArtikel = $artikel->skip(1)->first();
                
                Komentar::create([
                    'id_artikel' => $secondArtikel->id_artikel,
                    'id_user' => $users->where('role', 'siswa')->first()->id_user,
                    'komentar' => 'Selamat untuk para pemenang olimpiade! Kalian adalah kebanggaan sekolah.',
                    'tanggal' => now()->subMinutes(45)
                ]);
            }
        }
    }
}