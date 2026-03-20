<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TestRole extends Command
{
    protected $signature = 'test:role';
    protected $description = 'Test role functionality';

    public function handle()
    {
        $user = User::find(1);
        $this->info('User: ' . $user->email);
        $this->info('Has admin role: ' . ($user->hasRole('admin') ? 'YES' : 'NO'));
        $this->info('User roles: ' . $user->roles->pluck('name')->join(', '));
    }
}
