<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medidor extends Model
{
    protected $fillable = [
        'cliente_id',
        'numero_medidor',
        'lectura_actual',
        'lectura_anterior',
        'estado',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
