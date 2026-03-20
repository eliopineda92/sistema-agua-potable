<x-layouts.admin :title="'Cobros'">

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Cobros</h1>
       <a href="{{ route('cobros.create') }}"
   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
    + Nuevo Cobro
</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
<form method="GET" action="{{ route('cobros.index') }}" class="mb-4 flex gap-4">

    <input type="text"
           name="cliente"
           placeholder="Buscar cliente..."
           value="{{ request('cliente') }}"
           class="border rounded px-3 py-2">

    <select name="estado" class="border rounded px-3 py-2">
        <option value="">-- Estado --</option>
        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
        <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
    </select>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded">
        Buscar
    </button>

    <a href="{{ route('cobros.index') }}"
       class="bg-gray-500 text-white px-4 py-2 rounded">
        Limpiar
    </a>

</form>
    <table class="w-full bg-white rounded-lg shadow-lg">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Cliente</th>
                <th class="p-3 text-left">Monto</th>
                <th class="p-3 text-left">Mora</th>
                <th class="p-3 text-left">Estado</th>
                <th class="p-3 text-left">Vencimiento</th>
                <th class="p-3 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cobros as $cobro)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $cobro->cliente->nombre }}</td>
                <td class="p-3">${{ number_format($cobro->monto, 2) }}</td>
                <td class="p-3">${{ number_format($cobro->mora, 2) }}</td>
                
                    <td class="p-3">
    @php
        $color = match($cobro->estado) {
            'pagado' => 'bg-green-200 text-green-800',
            'vencido' => 'bg-red-200 text-red-800',
            default => 'bg-yellow-200 text-yellow-800',
        };
    @endphp

    <span class="px-3 py-1 rounded text-sm {{ $color }}">
        {{ ucfirst($cobro->estado) }}
    </span>
</td>
                </td>
                <td class="p-3">{{ $cobro->fecha_vencimiento->format('d/m/Y') }}</td>
                <td class="p-3 space-x-2">

   @if($cobro->estado === 'pendiente' || $cobro->estado === 'vencido')
    <a href="{{ route('cobros.pagar', $cobro) }}" class="text-green-600 hover:underline">Registrar Pago</a>
		@endif

		@if($cobro->estado === 'pagado')
    <a href="{{ route('cobros.descargar-comprobante', $cobro) }}" class="text-blue-600 hover:underline">
        Descargar Comprobante
    </a>
		@endif



    <a href="{{ route('cobros.edit', $cobro) }}" class="text-blue-500 hover:underline">
        Editar
    </a>

    <form action="{{ route('cobros.destroy', $cobro) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-500 hover:underline">
            Eliminar
        </button>
    </form>
	

</td>
            </tr>
            @endforeach
        </tbody>
    </table>
	<div class="mt-4">
    {{ $cobros->links() }}
</div>
</div>
</x-layouts.admin>
