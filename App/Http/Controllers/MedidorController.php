<?php

namespace App\Http\Controllers;

use App\Models\Medidor;
use App\Models\Cliente;
use Illuminate\Http\Request;

class MedidorController extends Controller
{
    public function index()
    {
        $medidores = Medidor::with('cliente')->paginate(15);
        return view('medidores.index', compact('medidores'));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')->get();
        return view('medidores.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero_medidor' => 'required|unique:medidores',
            'ubicacion' => 'required|string|max:255',
            'cuota_mensual' => 'required|numeric|min:0.01',
        ]);

        Medidor::create($validated);

        return redirect()->route('medidores.index')->with('success', 'Medidor creado exitosamente.');
    }

    public function edit(Medidor $medidor)
    {
        $clientes = Cliente::where('estado', 'activo')->get();
        return view('medidores.edit', compact('medidor', 'clientes'));
    }

    public function update(Request $request, Medidor $medidor)
    {
        $validated = $request->validate([
            'numero_medidor' => 'required|unique:medidores,numero_medidor,' . $medidor->id,
            'ubicacion' => 'required|string|max:255',
            'cuota_mensual' => 'required|numeric|min:0.01',
            'estado' => 'required|in:activo,inactivo,suspendido',
        ]);

        $medidor->update($validated);

        return redirect()->route('medidores.index')->with('success', 'Medidor actualizado exitosamente.');
    }

    public function destroy(Medidor $medidor)
    {
        $medidor->delete();
        return redirect()->route('medidores.index')->with('success', 'Medidor eliminado exitosamente.');
    }
}
