<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h1 class="text-2xl font-bold mb-6">Sistema de Agua Potable</h1>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Contraseña</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded-lg">Login</button>
            </form>
        </div>
    </div>
</body>
</html>