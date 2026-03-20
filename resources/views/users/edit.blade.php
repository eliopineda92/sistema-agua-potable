@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Editar Usuario: {{ $user->name }}</h1>
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
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Nombre</label>
                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Roles</label>
                <div class="space-y-2">
                    @foreach($roles as $role)
                        <label class="flex items-center">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="mr-3" {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}>
                            <span class="text-gray-700">{{ ucfirst($role->name) }} - {{ $role->description }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Actualizar Usuario
                </button>
                <a href="{{ route('users.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
