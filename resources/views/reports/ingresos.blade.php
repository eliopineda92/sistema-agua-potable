@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Ingresos Anuales</h1>
        <a href="{{ route('reports.index') }}" class="text-blue-600 hover:text-blue-800">← Volver</a>
    </div>

    <!-- Filtro por año -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" class="flex gap-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Selecciona Año</label>
                <input type="number" name="ano" value="{{ $ano }}" min="2020" max="{{ now()->year + 1 }}" class="px-4 py-2 border border-gray-300 rounded-lg w-40">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 self-end">
                Filtrar
            </button>
        </form>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Total Anual {{ $ano }}</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalAnual, 2) }}</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Promedio Mensual</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">${{ number_format($promedio, 2) }}</p>
        </div>
    </div>

    <!-- Tabla de Ingresos Mensuales -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Mes</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Ingreso</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">% del Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingresosPorMes as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-3 font-semibold">{{ $item['mes'] }}</td>
                    <td class="px-6 py-3 font-bold text-green-600">${{ number_format($item['ingreso'], 2) }}</td>
                    <td class="px-6 py-3">
                        @if($totalAnual > 0)
                            {{ number_format(($item['ingreso'] / $totalAnual) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Gráfico visual simple -->
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Distribución de Ingresos</h2>
        <div class="space-y-3">
            @foreach($ingresosPorMes as $item)
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ $item['mes'] }}</span>
                    <span class="text-sm font-bold text-gray-900">${{ number_format($item['ingreso'], 2) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $totalAnual > 0 ? ($item['ingreso'] / $totalAnual) * 100 : 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
