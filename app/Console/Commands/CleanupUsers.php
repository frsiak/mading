<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CleanupUsers extends Command
{
    protected $signature = 'users:cleanup';
    protected $description = 'Keep only 4 essential users';

    public function handle()
    {
        // Keep these essential users
        $keepUsers = ['admin', 'guru1', 'siswa1', 'friska'];
        
        // Delete all users except the ones we want to keep
        $deletedCount = User::whereNotIn('username', $keepUsers)->delete();
        
        $this->info("Deleted {$deletedCount} users. Kept 4 essential users.");
        
        return 0;
    }
}