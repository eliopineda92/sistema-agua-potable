@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Registro de Cliente</h1>
        <p class="text-gray-600 mt-2">Crea tu cuenta para acceder al portal</p>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-8 max-w-md">
        <form action="{{ route('cliente.register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Selecciona tu cliente</label>
                <select name="cliente_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">-- Selecciona tu nombre --</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }} (Medidor: {{ $cliente->numero_medidor }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Contraseña</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold">
                Registrarse
            </button>

            <p class="text-center mt-4">¿Ya tienes cuenta? <a href="{{ route('cliente.login') }}" class="text-blue-600 font-bold">Inicia sesión</a></p>
        </form>
    </div>
</div>
@endsection
