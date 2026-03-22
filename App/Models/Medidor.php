<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medidor extends Model
{
    protected $table = 'medidores';
    
    protected $fillable = [
        'cliente_id',
        'numero_medidor',
        'ubicacion',
        'cuota_mensual',
        'estado',
    ];

    protected $casts = [
        'cuota_mensual' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function lecturas(): HasMany
    {
        return $this->hasMany(Lectura::class);
    }

    public function cobros(): HasMany
    {
        return $this->hasMany(Cobro::class);
    }
}
