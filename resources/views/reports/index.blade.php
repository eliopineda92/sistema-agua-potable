@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Centro de Reportes</h1>

    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Clientes Activos</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalClientes }}</p>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Total Recaudado</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalRecaudado, 2) }}</p>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Pendiente</h3>
            <p class="text-3xl font-bold text-yellow-600 mt-2">${{ number_format($totalPendiente, 2) }}</p>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">En Mora</h3>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $clientesEnMora }}</p>
        </div>

        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-gray-600 text-sm font-semibold">Cobros Generados</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalCobrosGenerados }}</p>
        </div>
    </div>

    <!-- Enlaces a Reportes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Recaudación -->
        <a href="{{ route('reports.recaudacion') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="text-4xl mb-3">💰</div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Recaudación</h2>
            <p class="text-gray-600">Ver pagos recibidos por mes y analizar tendencias de recaudación</p>
            <div class="mt-4 text-blue-600 font-semibold">Ver reporte →</div>
        </a>

        <!-- Clientes en Mora -->
        <a href="{{ route('reports.mora') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="text-4xl mb-3">⚠️</div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Clientes en Mora</h2>
            <p class="text-gray-600">Identificar clientes con cobros vencidos y monto adeudado</p>
            <div class="mt-4 text-red-600 font-semibold">Ver reporte →</div>
        </a>

        <!-- Ingresos Anuales -->
        <a href="{{ route('reports.ingresos') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="text-4xl mb-3">📊</div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Ingresos Anuales</h2>
            <p class="text-gray-600">Visualizar ingresos mensuales y totales del año</p>
            <div class="mt-4 text-green-600 font-semibold">Ver reporte →</div>
        </a>
    </div>
</div>
@endsection
