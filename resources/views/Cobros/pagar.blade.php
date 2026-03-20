<x-layouts.admin :title="'Registrar Pago'">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <h1 class="text-3xl font-bold mb-8">Registrar Pago</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-xl font-bold mb-4">Detalles del Cobro</h2>
            <p><strong>Cliente:</strong> {{ $cobro->cliente->nombre }}</p>
            <p><strong>Monto:</strong> ${{ number_format($cobro->monto, 2) }}</p>
            <p><strong>Mora:</strong> ${{ number_format($cobro->mora, 2) }}</p>
            <p><strong>Total Adeudado:</strong> <span class="text-red-600 font-bold">${{ number_format($cobro->monto + $cobro->mora, 2) }}</span></p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cobros.guardar-pago', $cobro) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Monto a Pagar</label>
                <input type="number" name="monto_pagado" step="0.01" value="{{ old('monto_pagado', $cobro->monto + $cobro->mora) }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Fecha del Pago</label>
                <input type="date" name="fecha_pago" value="{{ old('fecha_pago', now()->format('Y-m-d')) }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Método de Pago</label>
                <select name="metodo_pago" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">Selecciona un método</option>
                    <option value="Transferencia">Transferencia Bancaria</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Tarjeta">Tarjeta de Crédito</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Observaciones</label>
                <textarea name="observaciones" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('observaciones') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Registrar Pago</button>
                <a href="{{ route('cobros.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
