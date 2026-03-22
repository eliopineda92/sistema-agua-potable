@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Editar Lectura - {{ $lectura->cliente->nombre }}</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
        <form action="{{ route('lecturas.update', $lectura) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6 bg-gray-100 p-4 rounded">
                <p class="text-gray-700"><strong>Cliente:</strong> {{ $lectura->cliente->nombre }}</p>
                <p class="text-gray-700"><strong>Período:</strong> {{ $lectura->periodo }}</p>
                <p class="text-gray-700"><strong>Medidor:</strong> {{ $lectura->cliente->numero_medidor }}</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Lectura Anterior (m³)</label>
                    <input type="number" name="lectura_anterior" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('lectura_anterior', $lectura->lectura_anterior) }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Lectura Actual (m³)</label>
                    <input type="number" name="lectura_actual" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('lectura_actual', $lectura->lectura_actual) }}">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Fecha de Lectura</label>
                <input type="date" name="fecha_lectura" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('fecha_lectura', $lectura->fecha_lectura->toDateString()) }}">
            </div>

            <!-- Información actual -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="font-bold text-gray-900 mb-3">Información Actual:</h3>
                <p class="text-sm text-gray-700">Metros Consumidos: <strong>{{ number_format($lectura->metros_consumidos, 2) }} m³</strong></p>
                <p class="text-sm text-gray-700">Monto Cobro: <strong>${{ number_format($lectura->monto_cobro, 2) }}</strong></p>
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
                    Actualizar Lectura
                </button>
                <a href="{{ route('lecturas.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
