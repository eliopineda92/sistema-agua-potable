<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lectura extends Model
{
    protected $fillable = [
        'medidor_id',
        'cliente_id',
        'periodo',
        'lectura_anterior',
        'lectura_actual',
        'metros_consumidos',
        'monto_cobro',
        'fecha_lectura',
    ];

    protected $casts = [
        'fecha_lectura' => 'date',
        'lectura_anterior' => 'decimal:2',
        'lectura_actual' => 'decimal:2',
        'metros_consumidos' => 'decimal:2',
        'monto_cobro' => 'decimal:2',
    ];

    public function medidor(): BelongsTo
    {
        return $this->belongsTo(Medidor::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cobro(): HasOne
    {
        return $this->hasOne(Cobro::class, 'lectura_id');
    }

    // Calcular monto basado en consumo
    public static function calcularMonto($metros_consumidos)
    {
        if ($metros_consumidos <= 5) {
            return 10.00;
        }
        
        $metros_adicionales = $metros_consumidos - 5;
        return 10.00 + ($metros_adicionales * 0.75);
    }
}
