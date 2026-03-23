@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Medidores</h1>
        <a href="{{ route('medidores.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nuevo Medidor
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Cliente</th>
                    <th class="border border-gray-300 px-4 py-2">Número Medidor</th>
                    <th class="border border-gray-300 px-4 py-2">Ubicación</th>
                    <th class="border border-gray-300 px-4 py-2">Cuota Mensual</th>
                    <th class="border border-gray-300 px-4 py-2">Estado</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medidores as $medidor)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $medidor->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $medidor->cliente->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $medidor->numero_medidor }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $medidor->ubicacion }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $medidor->cuota_mensual }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <span class="px-2 py-1 rounded text-white {{ $medidor->estado === 'activo' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $medidor->estado }}
                            </span>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('medidores.edit', $medidor) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form method="POST" action="{{ route('medidores.destroy', $medidor) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border border-gray-300 px-4 py-2 text-center text-gray-500">No hay medidores registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $medidores->links() }}
    </div>
</div>
@endsection
