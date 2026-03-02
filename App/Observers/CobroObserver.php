<?php

namespace App\Observers;

use App\Models\Cobro;

class CobroObserver
{
    public function updated(Cobro $cobro): void
    {
        $this->verificarVencimiento($cobro);
    }

    public function creating(Cobro $cobro): void
    {
        $this->verificarVencimiento($cobro);
    }

    private function verificarVencimiento(Cobro $cobro): void
    {
        // Si está vencido y aún está pendiente, marcar como vencido y calcular mora
        if (now() > $cobro->fecha_vencimiento && $cobro->estado === 'pendiente') {
            $mora = $cobro->monto * 0.05; // 5% de mora
            $cobro->estado = 'vencido';
            $cobro->mora = $mora;
        }
    }
}
