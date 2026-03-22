<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar las columnas a medidores directamente con ALTER TABLE
        try {
            DB::statement('ALTER TABLE medidores ADD COLUMN numero_medidor VARCHAR(255) UNIQUE NOT NULL');
        } catch (\Exception $e) {
            // Columna ya existe
        }

        try {
            DB::statement('ALTER TABLE medidores ADD COLUMN cliente_id BIGINT UNSIGNED NOT NULL');
        } catch (\Exception $e) {
            // Columna ya existe
        }

        try {
            DB::statement('ALTER TABLE medidores ADD COLUMN ubicacion VARCHAR(255) DEFAULT "Principal" NOT NULL');
        } catch (\Exception $e) {
            // Columna ya existe
        }

        try {
            DB::statement('ALTER TABLE medidores ADD COLUMN cuota_mensual DECIMAL(10,2) DEFAULT 10.00 NOT NULL');
        } catch (\Exception $e) {
            // Columna ya existe
        }

        try {
            DB::statement('ALTER TABLE medidores ADD COLUMN estado ENUM("activo", "inactivo", "suspendido") DEFAULT "activo" NOT NULL');
        } catch (\Exception $e) {
            // Columna ya existe
        }

        // Copiar datos de clientes a medidores
        if (DB::table('medidores')->count() == 0) {
            $clientes = DB::table('clientes')->get();
            foreach ($clientes as $cliente) {
                try {
                    DB::table('medidores')->insert([
                        'cliente_id' => $cliente->id,
                        'numero_medidor' => $cliente->numero_medidor,
                        'ubicacion' => 'Principal',
                        'cuota_mensual' => $cliente->cuota_mensual,
                        'estado' => 'activo',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    // Ya existe
                }
            }
        }

        // Agregar medidor_id a lecturas
        try {
            DB::statement('ALTER TABLE lecturas ADD COLUMN medidor_id BIGINT UNSIGNED NULL AFTER cliente_id');
            DB::statement('ALTER TABLE lecturas ADD CONSTRAINT lecturas_medidor_id_foreign FOREIGN KEY (medidor_id) REFERENCES medidores(id) ON DELETE CASCADE');

            // Llenar medidor_id
            $medidores = DB::table('medidores')->get();
            foreach ($medidores as $medidor) {
                DB::table('lecturas')
                    ->where('cliente_id', $medidor->cliente_id)
                    ->update(['medidor_id' => $medidor->id]);
            }
        } catch (\Exception $e) {
            // Ya existe
        }

        // Agregar medidor_id a cobros
        try {
            DB::statement('ALTER TABLE cobros ADD COLUMN medidor_id BIGINT UNSIGNED NULL AFTER cliente_id');
            DB::statement('ALTER TABLE cobros ADD CONSTRAINT cobros_medidor_id_foreign FOREIGN KEY (medidor_id) REFERENCES medidores(id) ON DELETE CASCADE');

            // Llenar medidor_id
            $medidores = DB::table('medidores')->get();
            foreach ($medidores as $medidor) {
                DB::table('cobros')
                    ->where('cliente_id', $medidor->cliente_id)
                    ->where('medidor_id', null)
                    ->update(['medidor_id' => $medidor->id]);
            }
        } catch (\Exception $e) {
            // Ya existe
        }
    }

    public function down(): void
    {
        //
    }
};
