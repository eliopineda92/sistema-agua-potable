<!DOCTYPE html>
<html>
<head>
    <title>Login - Portal del Cliente</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h1 class="text-2xl font-bold mb-2">Portal del Cliente</h1>
            <p class="text-gray-600 text-sm mb-6">Sistema de Agua Potable</p>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('cliente.login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg" required value="{{ old('email') }}">
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">Contraseña</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-2 text-gray-500">
                            👁️
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded-lg hover:bg-green-700 mb-4">
                    Iniciar Sesión
                </button>
            </form>

            <!-- Separator -->
            <div class="border-t border-gray-300 my-6"></div>

            <!-- Admin Portal Link -->
            <p class="text-center text-gray-600 text-sm mb-3">¿No tienes cuenta?</p>
            <a href="{{ route('cliente.register') }}" class="w-full block text-center bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 mb-4">
                Registrarse
            </a>

            <!-- Admin Login Link -->
            <p class="text-center text-gray-600 text-sm mb-3">¿Eres administrador?</p>
            <a href="{{ route('login') }}" class="w-full block text-center bg-gray-600 text-white font-bold py-2 rounded-lg hover:bg-gray-700">
                Panel de Administración
            </a>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>
</body>
</html>
