@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestión de Roles</h1>
        <a href="{{ route('roles.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            + Crear Rol
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Descripción</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Permisos</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Usuarios</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-3 font-semibold">{{ ucfirst($role->name) }}</td>
                    <td class="px-6 py-3">{{ $role->description }}</td>
                    <td class="px-6 py-3">
                        <div class="flex gap-1 flex-wrap">
                            @forelse($role->permissions as $permission)
                                <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                    {{ $permission->name }}
                                </span>
                            @empty
                                <span class="text-gray-500 text-sm">Sin permisos</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-3">
                        <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $role->users->count() }}
                        </span>
                    </td>
                    <td class="px-6 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('roles.edit', $role) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                Editar
                            </a>
                            @if($role->name !== 'admin')
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Estás seguro?')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-600">
                        No hay roles registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $roles->links() }}
    </div>
</div>
@endsection
