<x-layouts.admin :title="'Nuevo Cobro'">

<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-3xl font-bold mb-8">Crear Cobro</h1>

    <form action="{{ route('cobros.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Cliente</label>
            <select name="cliente_id" class="w-full px-3 py-2 border rounded-lg @error('cliente_id') border-red-500 @enderror" required>
                <option value="">Selecciona un cliente</option>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            @error('cliente_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Fecha de Cobro</label>
            <input type="date" name="fecha_cobro" class="w-full px-3 py-2 border rounded-lg @error('fecha_cobro') border-red-500 @enderror" required>
            @error('fecha_cobro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Monto</label>
            <input type="number" name="monto" step="0.01" class="w-full px-3 py-2 border rounded-lg @error('monto') border-red-500 @enderror" required>
            @error('monto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
		<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Período</label>
    <input type="month" name="periodo"
           value="{{ old('periodo') }}"
           class="w-full border rounded px-3 py-2"
           required>
    @error('periodo')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="w-full px-3 py-2 border rounded-lg @error('fecha_vencimiento') border-red-500 @enderror" required>
            @error('fecha_vencimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</button>
            <a href="{{ route('cobros.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
        </div>
    </form>
</div>
</x-layouts.admin>
