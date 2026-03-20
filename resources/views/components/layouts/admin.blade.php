<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Panel Administrativo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-black-800">

<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col">

        <div class="p-6 text-2xl font-bold border-b border-slate-700">
            💧 Agua Potable
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">

            @if(Auth::user()->hasAnyRole(['admin', 'cajero', 'supervisor']))
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 transition">
                    Dashboard
                </a>

                <a href="{{ route('clientes.index') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 transition">
                    Clientes
                </a>
            @endif

            @if(Auth::user()->hasAnyRole(['admin', 'cajero']))
                <a href="{{ route('cobros.index') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 transition">
                    Cobros
                </a>
            @endif

            @if(Auth::user()->hasRole('admin'))
                <div class="border-t border-slate-700 my-2"></div>
                <p class="px-4 py-2 text-xs uppercase text-slate-400 font-semibold">Administración</p>
                
                <a href="{{ route('users.index') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 transition">
                    👤 Usuarios
                </a>

                <a href="{{ route('roles.index') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 transition">
                    🔐 Roles
                </a>
            @endif

            @if(Auth::user()->hasRole('cliente'))
                <a href="{{ route('cliente.dashboard') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 transition">
                    Mi Cuenta
                </a>
            @endif

        </nav>

        <div class="p-4 border-t border-slate-700">
            <div class="text-xs text-slate-400 mb-3">
                <p class="font-semibold">{{ Auth::user()->name }}</p>
                <p class="text-slate-500">{{ Auth::user()->email }}</p>
                <p class="text-slate-600 text-xs mt-1">
                    @foreach(Auth::user()->roles as $role)
                        <span class="inline-block bg-slate-700 px-2 py-1 rounded">{{ ucfirst($role->name) }}</span>
                    @endforeach
                </p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded text-white font-semibold">
                    Cerrar sesión
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-8">

        <h1 class="text-3xl font-bold mb-8 text-gray-900">
            {{ $title ?? '' }}
        </h1>

        <div class="bg-white rounded-lg shadow p-6" text-gray-800>
            {{ $slot }}
        </div>

    </main>

</div>

</body>
</html>
