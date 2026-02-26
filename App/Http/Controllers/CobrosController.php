<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CobrosController extends Controller
{
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
    if ($cobro->estado === 'pagado') {
        return back()->with('error', 'Este cobro ya está pagado.');
    }

    $cobro->update([
        'estado' => 'pagado',
        'fecha_pago' => now()
    ]);

    return back()->with('success', 'Pago registrado correctamente.');
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
