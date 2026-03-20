<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;

class AssignSupervisor extends Command
{
    protected $signature = 'user:assign-supervisor {email}';
    protected $description = 'Assign supervisor role to a user';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '$email' not found");
            return;
        }

        $supervisorRole = Role::where('name', 'supervisor')->first();

        if (!$supervisorRole) {
            $this->error("Supervisor role not found");
            return;
        }

        $user->roles()->sync([$supervisorRole->id]);

        $this->info("User '$email' has been assigned the supervisor role");
    }
}
