@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Crear Medidor</h1>

    <form method="POST" action="{{ route('medidores.store') }}" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label for="cliente_id" class="block text-gray-700 font-semibold mb-2">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="w-full border border-gray-300 rounded px-3 py-2 @error('cliente_id') border-red-500 @enderror" required>
                <option value="">Seleccionar cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
            @error('cliente_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="numero_medidor" class="block text-gray-700 font-semibold mb-2">Número de Medidor</label>
            <input type="text" name="numero_medidor" id="numero_medidor" value="{{ old('numero_medidor') }}" class="w-full border border-gray-300 rounded px-3 py-2 @error('numero_medidor') border-red-500 @enderror" required>
            @error('numero_medidor')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="ubicacion" class="block text-gray-700 font-semibold mb-2">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}" class="w-full border border-gray-300 rounded px-3 py-2 @error('ubicacion') border-red-500 @enderror" required>
            @error('ubicacion')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cuota_mensual" class="block text-gray-700 font-semibold mb-2">Cuota Mensual</label>
            <input type="number" name="cuota_mensual" id="cuota_mensual" value="{{ old('cuota_mensual') }}" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2 @error('cuota_mensual') border-red-500 @enderror" required>
            @error('cuota_mensual')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Crear</button>
            <a href="{{ route('medidores.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancelar</a>
        </div>
    </form>
</div>
@endsection
