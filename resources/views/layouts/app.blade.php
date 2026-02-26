<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agua Potable</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">💧 Agua Potable</h1>
            <ul class="flex gap-6">
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-200">Dashboard</a></li>
                <li><a href="{{ route('clientes.index') }}" class="hover:text-blue-200">Clientes</a></li>
                <li><a href="{{ route('cobros.index') }}" class="hover:text-blue-200">Cobros</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-12">
        <p>&copy; 2026 Sistema de Agua Potable. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
