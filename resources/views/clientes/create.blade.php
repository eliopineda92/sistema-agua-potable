<x-layouts.admin :title="'Agregar Cliente'">

<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-3xl font-bold mb-8">Crear Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nombre</label>
            <input type="text" name="nombre" class="w-full px-3 py-2 border rounded-lg @error('nombre') border-red-500 @enderror" required>
            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Dirección</label>
            <input type="text" name="direccion" class="w-full px-3 py-2 border rounded-lg @error('direccion') border-red-500 @enderror" required>
            @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Número de Medidor</label>
            <input type="text" name="numero_medidor" class="w-full px-3 py-2 border rounded-lg @error('numero_medidor') border-red-500 @enderror" required>
            @error('numero_medidor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Cuota Mensual</label>
            <input type="number" name="cuota_mensual" step="0.01" class="w-full px-3 py-2 border rounded-lg @error('cuota_mensual') border-red-500 @enderror" required>
            @error('cuota_mensual') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear</button>
            <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
        </div>
    </form>
</div>
</x-layouts.admin>
