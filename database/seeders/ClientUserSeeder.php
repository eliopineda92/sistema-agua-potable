<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Matias alejandro Pineda',
            'email' => 'matias@example.com',
            'password' => Hash::make('password123'),
            'cliente_id' => 1,
            'rol' => 'cliente'
        ]);
    }
}
