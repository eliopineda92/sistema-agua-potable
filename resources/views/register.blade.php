<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h1 class="text-2xl font-bold mb-6">Crear Cuenta</h1>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-bold mb-2">Nombre</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border rounded-lg" required value="{{ old('name') }}">
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg" required value="{{ old('email') }}">
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Selecciona tu Cliente</label>
                    <select name="cliente_id" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">-- Selecciona un cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }} (Medidor: {{ $cliente->numero_medidor }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Contraseña</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-2 text-gray-500">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Confirmar Contraseña</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-2 text-gray-500">
                            👁️
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded-lg mb-3">Registrar</button>

                <p class="text-center">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-500">Inicia sesión</a></p>
            </form>
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
