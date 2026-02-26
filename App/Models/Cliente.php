<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $fillable = [
        'nombre',
        'direccion',
        'numero_medidor',
        'cuota_mensual',
        'estado',
    ];

    public function medidores(): HasMany
    {
        return $this->hasMany(Medidor::class);
    }

    public function cobros(): HasMany
    {
        return $this->hasMany(Cobro::class);
    }
}
