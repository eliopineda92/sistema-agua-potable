<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Cliente;
use App\Models\Lectura;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $totalClientes = Cliente::where('estado', 'activo')->count();
        $totalCobrosGenerados = Cobro::count();
        $totalRecaudado = Cobro::where('estado', 'pagado')->sum('monto');
        $totalPendiente = Cobro::whereIn('estado', ['pendiente', 'vencido'])->sum('monto');
        $clientesEnMora = Cobro::where('estado', 'vencido')->distinct('cliente_id')->count('cliente_id');

        return view('reports.index', compact(
            'totalClientes',
            'totalCobrosGenerados',
            'totalRecaudado',
            'totalPendiente',
            'clientesEnMora'
        ));
    }

    public function recaudacion(Request $request)
    {
        $mes = $request->get('mes', now()->format('Y-m'));
        
        $recaudaciones = Cobro::where('estado', 'pagado')
            ->whereMonth('fecha_pago', date('m', strtotime($mes . '-01')))
            ->whereYear('fecha_pago', date('Y', strtotime($mes . '-01')))
            ->with('cliente')
            ->get();

        $totalRecaudado = $recaudaciones->sum('monto');
        $totalCobros = $recaudaciones->count();
        $promedioPago = $totalCobros > 0 ? $totalRecaudado / $totalCobros : 0;

        return view('reports.recaudacion', compact(
            'recaudaciones',
            'totalRecaudado',
            'totalCobros',
            'promedioPago',
            'mes'
        ));
    }

    public function mora(Request $request)
    {
        $clientesEnMora = Cobro::where('estado', 'vencido')
            ->with('cliente')
            ->get()
            ->groupBy('cliente_id');

        $detalles = [];
        $totalEnMora = 0;

        foreach ($clientesEnMora as $clienteId => $cobros) {
            $cliente = $cobros->first()->cliente;
            $montotal = $cobros->sum('monto');
            $totalEnMora += $montotal;

            $detalles[] = [
                'cliente' => $cliente,
                'cobros' => $cobros,
                'total' => $montotal,
                'diasVencidos' => $cobros->map(function($c) {
                    return now()->diffInDays($c->fecha_vencimiento);
                })->max(),
            ];
        }

        // Ordenar por monto descendente
        usort($detalles, function($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        return view('reports.mora', compact('detalles', 'totalEnMora'));
    }

    public function ingresos(Request $request)
    {
        $ano = $request->get('ano', now()->year);
        
        $ingresosPorMes = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $inicio = Carbon::create($ano, $mes, 1)->startOfMonth();
            $fin = Carbon::create($ano, $mes, 1)->endOfMonth();

            $ingreso = Cobro::where('estado', 'pagado')
                ->whereBetween('fecha_pago', [$inicio, $fin])
                ->sum('monto');

            $ingresosPorMes[] = [
                'mes' => $inicio->format('M Y'),
                'ingreso' => (float) $ingreso,
            ];
        }

        $totalAnual = array_sum(array_column($ingresosPorMes, 'ingreso'));
        $promedio = $totalAnual / 12;

        return view('reports.ingresos', compact('ingresosPorMes', 'totalAnual', 'promedio', 'ano'));
    }
}
