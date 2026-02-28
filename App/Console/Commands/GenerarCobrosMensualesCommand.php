<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\Cobro;
use Illuminate\Console\Command;

class GenerarCobrosMensualesCommand extends Command
{
    protected $signature = 'cobros:generar-mensuales';

    protected $description = 'Genera automáticamente cobros mensuales para todos los clientes activos';

    public function handle()
    {
        $clientes = Cliente::where('estado', 'activo')->get();

        $periodo = now()->format('Y-m');
        $cobrosgenerados = 0;

        foreach ($clientes as $cliente) {
            // Verificar si ya existe cobro para este mes
            $existe = Cobro::where('cliente_id', $cliente->id)
                ->where('periodo', $periodo)
                ->exists();

            if (!$existe) {
                Cobro::create([
                    'cliente_id' => $cliente->id,
                    'periodo' => $periodo,
                    'fecha_cobro' => now(),
                    'monto' => $cliente->cuota_mensual,
                    'fecha_vencimiento' => now()->addDays(30),
                    'estado' => 'pendiente',
                ]);
                $cobrosgenerados++;
            }
        }

        $this->info("✅ Cobros generados: $cobrosgenerados para el período $periodo");
    }
}
