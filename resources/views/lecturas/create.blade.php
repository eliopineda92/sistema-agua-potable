@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Registrar Nueva Lectura</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
        <form action="{{ route('lecturas.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required onchange="cargarUltimaLectura()">
                    <option value="">-- Selecciona un cliente --</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }} (Medidor: {{ $cliente->numero_medidor }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Período (YYYY-MM)</label>
                <input type="month" name="periodo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('periodo') }}">
                <p class="text-sm text-gray-600 mt-1">Ejemplo: 2026-03 para marzo 2026</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Lectura Anterior (m³)</label>
                    <input type="number" name="lectura_anterior" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('lectura_anterior', 0) }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Lectura Actual (m³)</label>
                    <input type="number" name="lectura_actual" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('lectura_actual') }}">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Fecha de Lectura</label>
                <input type="date" name="fecha_lectura" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('fecha_lectura', now()->toDateString()) }}">
            </div>

            <!-- Tarifa Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-bold text-blue-900 mb-3">Tarifa de Consumo:</h3>
                <ul class="text-sm text-blue-800 space-y-2">
                    <li>• <strong>0 a 5 m³:</strong> $10.00 (tarifa fija)</li>
                    <li>• <strong>6 m³ en adelante:</strong> $10.00 + $0.75 por m³ adicional</li>
                </ul>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold">
                    Registrar Lectura
                </button>
                <a href="{{ route('lecturas.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function cargarUltimaLectura() {
    // Esta función puede usarse para cargar la última lectura de un cliente
    // Por ahora solo actualiza el formulario
    const clienteId = document.getElementById('cliente_id').value;
    if (clienteId) {
        console.log('Cliente seleccionado:', clienteId);
    }
}
</script>
@endsection
