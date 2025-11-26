<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Like;
use App\Models\User;

class AddLikesSeeder extends Seeder
{
    public function run(): void
    {
        $articles = Artikel::all();
        
        foreach ($articles as $article) {
            // Tambah 150 like untuk setiap artikel dengan user dummy
            for ($i = 1; $i <= 150; $i++) {
                // Buat user dummy untuk setiap like
                $dummyUser = User::create([
                    'nama' => 'Dummy User ' . $i,
                    'username' => 'dummy_' . $article->id_artikel . '_' . $i,
                    'email' => 'dummy' . $article->id_artikel . '_' . $i . '@example.com',
                    'password' => bcrypt('dummy123'),
                    'role' => 'siswa'
                ]);
                
                Like::create([
                    'id_artikel' => $article->id_artikel,
                    'id_user' => $dummyUser->id_user
                ]);
            }
        }
    }
}