@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Reporte de Recaudación</h1>
        <a href="{{ route('reports.index') }}" class="text-blue-600 hover:text-blue-800">← Volver</a>
    </div>

    <!-- Filtro por mes -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" class="flex gap-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Selecciona Mes</label>
                <input type="month" name="mes" value="{{ $mes }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 self-end">
                Filtrar
            </button>
        </form>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Total Recaudado</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalRecaudado, 2) }}</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Cantidad de Pagos</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalCobros }}</p>
        </div>

        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Promedio por Pago</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">${{ number_format($promedioPago, 2) }}</p>
        </div>
    </div>

    <!-- Tabla de Pagos -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Cliente</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Período</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Monto</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Fecha Pago</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recaudaciones as $cobro)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $cobro->cliente->nombre }}</td>
                    <td class="px-6 py-3">{{ $cobro->periodo }}</td>
                    <td class="px-6 py-3 font-bold text-green-600">${{ number_format($cobro->monto, 2) }}</td>
                    <td class="px-6 py-3 text-sm">{{ $cobro->fecha_pago->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-600">
                        No hay pagos registrados para este período
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
