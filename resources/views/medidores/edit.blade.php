@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Editar Medidor</h1>

    <form method="POST" action="{{ route('medidores.update', $medidor) }}" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="numero_medidor" class="block text-gray-700 font-semibold mb-2">Número de Medidor</label>
            <input type="text" name="numero_medidor" id="numero_medidor" value="{{ old('numero_medidor', $medidor->numero_medidor) }}" class="w-full border border-gray-300 rounded px-3 py-2 @error('numero_medidor') border-red-500 @enderror" required>
            @error('numero_medidor')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="ubicacion" class="block text-gray-700 font-semibold mb-2">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $medidor->ubicacion) }}" class="w-full border border-gray-300 rounded px-3 py-2 @error('ubicacion') border-red-500 @enderror" required>
            @error('ubicacion')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cuota_mensual" class="block text-gray-700 font-semibold mb-2">Cuota Mensual</label>
            <input type="number" name="cuota_mensual" id="cuota_mensual" value="{{ old('cuota_mensual', $medidor->cuota_mensual) }}" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2 @error('cuota_mensual') border-red-500 @enderror" required>
            @error('cuota_mensual')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="estado" class="block text-gray-700 font-semibold mb-2">Estado</label>
            <select name="estado" id="estado" class="w-full border border-gray-300 rounded px-3 py-2 @error('estado') border-red-500 @enderror" required>
                <option value="activo" {{ old('estado', $medidor->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('estado', $medidor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                <option value="suspendido" {{ old('estado', $medidor->estado) == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
            </select>
            @error('estado')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Actualizar</button>
            <a href="{{ route('medidores.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancelar</a>
        </div>
    </form>
</div>
@endsection
