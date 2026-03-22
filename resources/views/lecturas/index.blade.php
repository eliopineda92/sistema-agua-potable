@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestión de Lecturas</h1>
        <a href="{{ route('lecturas.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            + Nueva Lectura
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Cliente</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Período</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Lectura Anterior</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Lectura Actual</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Metros Consumidos</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Monto</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Fecha</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lecturas as $lectura)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $lectura->cliente->nombre }}</td>
                    <td class="px-6 py-3">{{ $lectura->periodo }}</td>
                    <td class="px-6 py-3 text-center">{{ number_format($lectura->lectura_anterior, 2) }}</td>
                    <td class="px-6 py-3 text-center">{{ number_format($lectura->lectura_actual, 2) }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded">
                            {{ number_format($lectura->metros_consumidos, 2) }} m³
                        </span>
                    </td>
                    <td class="px-6 py-3 font-bold">${{ number_format($lectura->monto_cobro, 2) }}</td>
                    <td class="px-6 py-3 text-sm">{{ $lectura->fecha_lectura->format('d/m/Y') }}</td>
                    <td class="px-6 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('lecturas.edit', $lectura) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                Editar
                            </a>
                            <form action="{{ route('lecturas.destroy', $lectura) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro?')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-600">
                        No hay lecturas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $lecturas->links() }}
    </div>
</div>
@endsection
