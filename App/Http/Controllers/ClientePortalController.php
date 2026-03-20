<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ClientePortalController extends Controller
{
    public function dashboard()
    {
        $cliente = Auth::guard('cliente')->user();

        $cobrosPendientes = $cliente->cobros()
            ->whereIn('estado', ['pendiente', 'vencido'])
            ->get();

        $cobrosPagados = $cliente->cobros()
            ->where('estado', 'pagado')
            ->orderBy('fecha_pago', 'desc')
            ->get();

        $totalPendiente = $cobrosPendientes->sum(fn($c) => $c->monto + $c->mora);
        $totalPagado = $cobrosPagados->sum(fn($c) => $c->monto + $c->mora);

        return view('cliente.dashboard', compact('cobrosPendientes', 'cobrosPagados', 'totalPendiente', 'totalPagado'));
    }
}
