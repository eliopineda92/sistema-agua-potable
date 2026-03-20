@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Crear Nuevo Rol</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Nombre del Rol</label>
                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="ej: supervisor" required value="{{ old('name') }}">
                <p class="text-sm text-gray-500 mt-1">Use caracteres alfanuméricos y guiones (sin espacios)</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Descripción</label>
                <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" rows="3" value="{{ old('description') }}"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Permisos</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 border border-gray-300 rounded-lg p-4 bg-gray-50">
                    @foreach($permissions as $permission)
                        <label class="flex items-start">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="mr-3 mt-1" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                            <div>
                                <span class="text-gray-700 font-medium">{{ $permission->name }}</span>
                                <p class="text-sm text-gray-600">{{ $permission->description }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Crear Rol
                </button>
                <a href="{{ route('roles.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
