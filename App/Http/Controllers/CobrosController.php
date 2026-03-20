<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CobrosController extends Controller
{
	public function descargarComprobante(Cobro $cobro)
{
    $pdf = PDF::loadView('cobros.comprobante', compact('cobro'));
    return $pdf->download('comprobante-pago-' . $cobro->id . '.pdf');
}

    public function index(Request $request)
{
    $query = Cobro::with('cliente');

    // Buscar por nombre del cliente
    if ($request->filled('cliente')) {
        $query->whereHas('cliente', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->cliente . '%');
        });
    }

    // Filtrar por estado
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    $cobros = $query->latest()->paginate(10)->withQueryString();

    return view('cobros.index', compact('cobros'));
}

    public function create()
    {
        $clientes = Cliente::all();
        return view('cobros.create', compact('clientes'));
    }
public function pagar(Cobro $cobro)
{
    return view('cobros.pagar', compact('cobro'));
}

public function registrarPago(Request $request, Cobro $cobro)
{
    $validated = $request->validate([
        'monto_pagado' => 'required|numeric|min:0.01',
        'fecha_pago' => 'required|date',
        'metodo_pago' => 'required|string',
        'observaciones' => 'nullable|string',
    ]);

    $total_cobro = $cobro->monto + $cobro->mora;

    if ($validated['monto_pagado'] > $total_cobro) {
        return back()->withErrors(['monto_pagado' => 'El monto no puede exceder el total adeudado']);
    }

    $cobro->update([
        'estado' => 'pagado',
        'fecha_pago' => $validated['fecha_pago'],
        'observaciones' => $validated['observaciones'],
        'metodo_pago' => $validated['metodo_pago'],
        'monto_pagado' => $validated['monto_pagado'],
    ]);

    return redirect()->route('cobros.index')->with('success', 'Pago registrado correctamente');
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'periodo' => 'required|string',
        'fecha_cobro' => 'required|date',
        'monto' => 'required|numeric|min:0',
        'fecha_vencimiento' => 'required|date',
    ]);

    // 🔥 Verificar que no exista el mismo periodo para el mismo cliente
    $existe = Cobro::where('cliente_id', $validated['cliente_id'])
        ->where('periodo', $validated['periodo'])
        ->exists();

    if ($existe) {
        return back()->withErrors([
            'periodo' => 'Este cliente ya tiene un cobro registrado para ese período.'
        ])->withInput();
    }

    // Crear cobro como pendiente
    $validated['estado'] = 'pendiente';

    Cobro::create($validated);

    return redirect()->route('cobros.index')->with('success', 'Cobro creado');
}

    public function show(Cobro $cobro)
    {
        return view('cobros.show', compact('cobro'));
    }

    public function edit(Cobro $cobro)
    {
        $clientes = Cliente::all();
        return view('cobros.edit', compact('cobro', 'clientes'));
    }

    public function update(Request $request, Cobro $cobro)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,pagado,vencido',
            'mora' => 'nullable|numeric|min:0',
        ]);

        if ($validated['estado'] === 'pagado') {
            $validated['fecha_pago'] = now();
        }

        $cobro->update($validated);
        return redirect()->route('cobros.index')->with('success', 'Cobro actualizado');
    }

    public function destroy(Cobro $cobro)
    {
        $cobro->delete();
        return redirect()->route('cobros.index')->with('success', 'Cobro eliminado');
    }
}
