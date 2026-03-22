@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Clientes en Mora</h1>
        <a href="{{ route('reports.index') }}" class="text-blue-600 hover:text-blue-800">← Volver</a>
    </div>

    <!-- Resumen -->
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-red-900 mb-2">Total en Mora</h3>
        <p class="text-3xl font-bold text-red-600">${{ number_format($totalEnMora, 2) }}</p>
    </div>

    <!-- Clientes en Mora -->
    @forelse($detalles as $detalle)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $detalle['cliente']->nombre }}</h2>
                <p class="text-gray-600 text-sm">Medidor: {{ $detalle['cliente']->numero_medidor }}</p>
                <p class="text-gray-600 text-sm">Dirección: {{ $detalle['cliente']->direccion }}</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-red-600">${{ number_format($detalle['total'], 2) }}</p>
                <p class="text-red-600 text-sm">{{ $detalle['diasVencidos'] }} días vencido</p>
            </div>
        </div>

        <!-- Cobros vencidos -->
        <div class="mt-4">
            <h3 class="font-semibold text-gray-700 mb-3">Cobros Vencidos:</h3>
            <div class="space-y-2">
                @foreach($detalle['cobros'] as $cobro)
                <div class="bg-gray-50 p-3 rounded flex justify-between">
                    <div>
                        <p class="font-semibold">{{ $cobro->periodo }}</p>
                        <p class="text-sm text-gray-600">Vencimiento: {{ $cobro->fecha_vencimiento->format('d/m/Y') }}</p>
                    </div>
                    <p class="font-bold text-red-600">${{ number_format($cobro->monto, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @empty
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
        <p class="text-green-700 font-semibold">✓ No hay clientes en mora</p>
    </div>
    @endforelse
</div>
@endsection
