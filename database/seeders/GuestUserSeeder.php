<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class GuestUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Guest User',
            'email' => 'guest@mading.com',
            'password' => bcrypt('guest123'),
            'role' => 'siswa'
        ]);
    }
}