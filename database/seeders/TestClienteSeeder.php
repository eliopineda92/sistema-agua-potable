<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Update first cliente with email and password
        $cliente = Cliente::find(1);
        if ($cliente) {
            $cliente->update([
                'email' => 'cliente@test.com',
                'password' => Hash::make('password123'),
            ]);
            echo "Cliente updated: email = cliente@test.com, password = password123\n";
        }

        // Add email/password to second cliente
        $cliente2 = Cliente::find(2);
        if ($cliente2) {
            $cliente2->update([
                'email' => 'elio@cliente.com',
                'password' => Hash::make('password123'),
            ]);
            echo "Cliente updated: email = elio@cliente.com, password = password123\n";
        }

        // Add email/password to third cliente
        $cliente3 = Cliente::find(3);
        if ($cliente3) {
            $cliente3->update([
                'email' => 'fatima@cliente.com',
                'password' => Hash::make('password123'),
            ]);
            echo "Cliente updated: email = fatima@cliente.com, password = password123\n";
        }
    }
}
