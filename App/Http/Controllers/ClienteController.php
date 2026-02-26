<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'numero_medidor' => 'required|string|unique:clientes',
            'cuota_mensual' => 'required|numeric|min:0',
        ]);

        Cliente::create($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente creado');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'numero_medidor' => 'required|string|unique:clientes,numero_medidor,' . $cliente->id,
            'cuota_mensual' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,suspendido',
        ]);

        $cliente->update($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado');
    }
}
