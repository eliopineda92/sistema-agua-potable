<?php

namespace App\Models;

use App\Observers\CobroObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cobro extends Model
{
    protected $fillable = [
        'cliente_id',
        'medidor_id',
        'lectura_id',
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
        'monto' => 'decimal:2',
        'mora' => 'decimal:2',
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

    public function medidor(): BelongsTo
    {
        return $this->belongsTo(Medidor::class);
    }

    public function lectura(): BelongsTo
    {
        return $this->belongsTo(Lectura::class);
    }

    protected static function booted(): void
    {
        static::observe(CobroObserver::class);
    }
}
