<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre',
        'direccion',
        'cuota_mensual',
        'estado',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function medidores(): HasMany
    {
        return $this->hasMany(Medidor::class);
    }

    public function cobros(): HasMany
    {
        return $this->hasMany(Cobro::class);
    }
}
