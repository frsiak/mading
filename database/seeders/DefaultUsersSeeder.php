<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin default
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // Guru default
        User::firstOrCreate(
            ['username' => 'guru'],
            [
                'nama' => 'Guru Pembimbing',
                'password' => Hash::make('guru123'),
                'role' => 'guru'
            ]
        );
    }
}
