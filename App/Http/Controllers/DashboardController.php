<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Cliente;
use Illuminate\Http\Request;

class DashboardController extends \App\Http\Controllers\Controller

{
    public function index()
    {
        $total_cobrado = Cobro::where('estado', 'pagado')->sum('monto');
        $total_pendiente = Cobro::where('estado', 'pendiente')->sum('monto');
        $clientes_mora = Cobro::where('estado', 'vencido')->count();
        $total_clientes = Cliente::count();

        $cobros_mes = Cobro::whereMonth('fecha_cobro', now()->month)
            ->whereYear('fecha_cobro', now()->year)
            ->get();

        return view('dashboard', compact(
            'total_cobrado',
            'total_pendiente',
            'clientes_mora',
            'total_clientes',
            'cobros_mes'
        ));
    }
}
