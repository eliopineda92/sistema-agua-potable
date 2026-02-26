<x-layouts.admin :title="'Editar Cobro'">

<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-3xl font-bold mb-8">Editar Cobro</h1>

    <form action="{{ route('cobros.update', $cobro) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Cliente</label>
            <select name="cliente_id" class="w-full px-3 py-2 border rounded-lg @error('cliente_id') border-red-500 @enderror" required>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" @selected($cobro->cliente_id === $cliente->id)>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            @error('cliente_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Estado</label>
            <select name="estado" class="w-full px-3 py-2 border rounded-lg @error('estado') border-red-500 @enderror" required>
                <option value="pendiente" @selected($cobro->estado === 'pendiente')>Pendiente</option>
                <option value="pagado" @selected($cobro->estado === 'pagado')>Pagado</option>
                <option value="vencido" @selected($cobro->estado === 'vencido')>Vencido</option>
            </select>
            @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Mora</label>
            <input type="number" name="mora" step="0.01" value="{{ $cobro->mora }}" class="w-full px-3 py-2 border rounded-lg @error('mora') border-red-500 @enderror">
            @error('mora') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
            <a href="{{ route('cobros.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
        </div>
    </form>
</div>
@endsection
