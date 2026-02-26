<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agua Potable</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div x-data="{ open: false }" class="flex h-screen">

    <!-- Sidebar -->
    <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
           class="fixed z-30 inset-y-0 left-0 w-64 bg-gray-900 text-gray-200 transform md:translate-x-0 md:static md:inset-0 transition duration-200 ease-in-out flex flex-col">

        <div class="p-6 text-xl font-bold border-b border-gray-700">
            💧 Agua Potable
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">
                📊 Dashboard
            </a>

            <a href="{{ route('clientes.index') }}"
               class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('clientes.*') ? 'bg-gray-800' : '' }}">
                👥 Clientes
            </a>

            <a href="{{ route('cobros.index') }}"
               class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('cobros.*') ? 'bg-gray-800' : '' }}">
                💰 Cobros
            </a>

        </nav>

        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white">
                    Cerrar sesión
                </button>
            </form>
        </div>

    </aside>

    <!-- Overlay móvil -->
    <div x-show="open"
         @click="open = false"
         class="fixed inset-0 bg-black opacity-50 z-20 md:hidden">
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Topbar móvil -->
        <header class="bg-white shadow md:hidden">
            <div class="flex items-center justify-between p-4">
                <button @click="open = !open"
                        class="text-gray-700 focus:outline-none">
                    ☰
                </button>
                <span class="font-semibold">Agua Potable</span>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-1 overflow-y-auto p-6">
            <h1 class="text-2xl font-semibold mb-6">
                {{ $title ?? '' }}
            </h1>

            {{ $slot }}
        </main>

    </div>

</div>

</body>
</html>