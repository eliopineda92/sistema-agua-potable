
<x-layouts.admin :title="'Clientes'">

<div class="flex justify-between items-center mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Lista de Clientes</h2>
    <a href="{{ route('clientes.create') }}"
   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
    + Nuevo Cliente
</a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Nombre</th>
                <th class="p-3 text-left">Dirección</th>
                <th class="p-3 text-left">Medidor</th>
                <th class="p-3 text-left">Cuota</th>
                <th class="p-3 text-left">Estado</th>
                <th class="p-3 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $cliente->nombre }}</td>
                <td class="p-3">{{ $cliente->direccion }}</td>
                <td class="p-3">{{ $cliente->numero_medidor }}</td>
                <td class="p-3">${{ number_format($cliente->cuota_mensual, 2) }}</td>
                <td class="p-3">
                    <span class="px-3 py-1 rounded text-white text-sm
                        {{ $cliente->estado === 'activo' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($cliente->estado) }}
                    </span>
                </td>
                <td class="p-3 space-x-2">
                    <a href="{{ route('clientes.edit', $cliente) }}"
                       class="text-blue-600 hover:underline">Editar</a>

                    <form action="{{ route('clientes.destroy', $cliente) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:underline">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-3 text-center text-gray-500">
                    No hay clientes registrados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-layouts.admin>
