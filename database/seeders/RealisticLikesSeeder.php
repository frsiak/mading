<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Like;
use App\Models\User;

class RealisticLikesSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Andi Pratama', 'Sari Dewi', 'Budi Santoso', 'Maya Sari', 'Rizki Ramadan',
            'Indah Permata', 'Doni Setiawan', 'Lina Marlina', 'Agus Wijaya', 'Rina Susanti',
            'Fajar Nugroho', 'Desi Ratnasari', 'Hendra Gunawan', 'Wati Suryani', 'Eko Prasetyo',
            'Fitri Handayani', 'Joko Widodo', 'Sinta Maharani', 'Bayu Setiawan', 'Dewi Lestari',
            'Arif Rahman', 'Nita Anggraini', 'Dimas Pratama', 'Yuni Astuti', 'Rudi Hartono',
            'Mega Putri', 'Adi Nugraha', 'Tari Wulandari', 'Gilang Ramadhan', 'Siska Amelia'
        ];
        
        $articles = Artikel::all();
        
        foreach ($articles as $article) {
            // Random 80-120 likes per artikel
            $likeCount = rand(80, 120);
            
            for ($i = 0; $i < $likeCount; $i++) {
                $randomName = $names[array_rand($names)];
                
                $user = User::create([
                    'nama' => $randomName,
                    'username' => strtolower(str_replace(' ', '_', $randomName)) . '_' . $article->id_artikel . '_' . $i,
                    'email' => strtolower(str_replace(' ', '', $randomName)) . $article->id_artikel . '_' . $i . '@gmail.com',
                    'password' => bcrypt('user123'),
                    'role' => 'siswa'
                ]);
                
                Like::create([
                    'id_artikel' => $article->id_artikel,
                    'id_user' => $user->id_user
                ]);
            }
        }
    }
}