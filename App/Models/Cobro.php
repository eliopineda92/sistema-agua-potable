<?php

namespace App\Models;

use App\Observers\CobroObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cobro extends Model
{
    protected $fillable = [
        'cliente_id',
        'periodo',
        'fecha_cobro',
        'monto',
        'mora',
        'estado',
        'fecha_vencimiento',
        'fecha_pago',
        'observaciones',
    ];

    protected $casts = [
        'fecha_cobro' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'datetime',
    ];

    protected $dates = [
        'fecha_cobro',
        'fecha_vencimiento',
        'fecha_pago',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    protected static function booted(): void
    {
        static::observe(CobroObserver::class);
    }
}
