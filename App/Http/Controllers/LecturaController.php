<?php

namespace App\Http\Controllers;

use App\Models\Lectura;
use App\Models\Medidor;
use App\Models\Cobro;
use Illuminate\Http\Request;

class LecturaController extends Controller
{
    public function index()
    {
        $lecturas = Lectura::with(['medidor', 'cliente'])->paginate(15);
        return view('lecturas.index', compact('lecturas'));
    }

    public function create()
    {
        $medidores = Medidor::with('cliente')->where('estado', 'activo')->get();
        return view('lecturas.create', compact('medidores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medidor_id' => 'required|exists:medidores,id',
            'periodo' => 'required|date_format:Y-m',
            'lectura_anterior' => 'required|numeric|min:0',
            'lectura_actual' => 'required|numeric|min:0|gt:lectura_anterior',
            'fecha_lectura' => 'required|date',
        ]);

        // Verificar si ya existe lectura para este medidor y período
        $lecturaExistente = Lectura::where('medidor_id', $validated['medidor_id'])
            ->where('periodo', $validated['periodo'])
            ->first();

        if ($lecturaExistente) {
            return back()->withErrors(['periodo' => 'Ya existe una lectura registrada para este medidor en el período ' . $validated['periodo']]);
        }

        // Obtener medidor para cliente_id y cuota
        $medidor = Medidor::find($validated['medidor_id']);

        // Calcular metros consumidos
        $metros_consumidos = $validated['lectura_actual'] - $validated['lectura_anterior'];
        
        // Calcular monto
        $monto_cobro = Lectura::calcularMonto($metros_consumidos);

        // Crear lectura
        $lectura = Lectura::create([
            'medidor_id' => $validated['medidor_id'],
            'cliente_id' => $medidor->cliente_id,
            'periodo' => $validated['periodo'],
            'lectura_anterior' => $validated['lectura_anterior'],
            'lectura_actual' => $validated['lectura_actual'],
            'metros_consumidos' => $metros_consumidos,
            'monto_cobro' => $monto_cobro,
            'fecha_lectura' => $validated['fecha_lectura'],
        ]);

        // Crear cobro automáticamente
        Cobro::create([
            'cliente_id' => $medidor->cliente_id,
            'medidor_id' => $validated['medidor_id'],
            'lectura_id' => $lectura->id,
            'periodo' => $validated['periodo'],
            'monto' => $monto_cobro,
            'fecha_cobro' => now()->toDateString(),
            'fecha_vencimiento' => now()->addDays(15)->toDateString(),
            'estado' => 'pendiente',
        ]);

        return redirect()->route('lecturas.index')->with('success', 'Lectura registrada y cobro generado exitosamente.');
    }

    public function edit(Lectura $lectura)
    {
        $medidores = Medidor::with('cliente')->where('estado', 'activo')->get();
        return view('lecturas.edit', compact('lectura', 'medidores'));
    }

    public function update(Request $request, Lectura $lectura)
    {
        $validated = $request->validate([
            'lectura_anterior' => 'required|numeric|min:0',
            'lectura_actual' => 'required|numeric|min:0|gt:lectura_anterior',
            'fecha_lectura' => 'required|date',
        ]);

        // Calcular nuevos metros consumidos y monto
        $metros_consumidos = $validated['lectura_actual'] - $validated['lectura_anterior'];
        $monto_cobro = Lectura::calcularMonto($metros_consumidos);

        // Actualizar lectura
        $lectura->update([
            'lectura_anterior' => $validated['lectura_anterior'],
            'lectura_actual' => $validated['lectura_actual'],
            'metros_consumidos' => $metros_consumidos,
            'monto_cobro' => $monto_cobro,
            'fecha_lectura' => $validated['fecha_lectura'],
        ]);

        // Actualizar cobro asociado
        if ($lectura->cobro) {
            $lectura->cobro->update(['monto' => $monto_cobro]);
        }

        return redirect()->route('lecturas.index')->with('success', 'Lectura actualizada exitosamente.');
    }

    public function destroy(Lectura $lectura)
    {
        // Eliminar cobro asociado si existe
        if ($lectura->cobro) {
            $lectura->cobro->delete();
        }

        $lectura->delete();
        return redirect()->route('lecturas.index')->with('success', 'Lectura eliminada exitosamente.');
    }
}
