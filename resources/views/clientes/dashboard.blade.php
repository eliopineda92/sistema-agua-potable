<x-layouts.admin :title="'Mi Estado de Cuenta'">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">📊 Mi Estado de Cuenta</h1>

        <!-- Información del Cliente -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Total Adeudado</h3>
                <p class="text-4xl font-bold mt-2">${{ number_format($totalPendiente, 2) }}</p>
            </div>

            <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Total Pagado</h3>
                <p class="text-4xl font-bold mt-2">${{ number_format($totalPagado, 2) }}</p>
            </div>

            <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Número de Medidor</h3>
                <p class="text-2xl font-bold mt-2">{{ auth()->user()->cliente->numero_medidor ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Mis Datos -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold mb-4">Mis Datos</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Nombre:</p>
                    <p class="font-bold">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Email:</p>
                    <p class="font-bold">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Dirección:</p>
                    <p class="font-bold">{{ auth()->user()->cliente->direccion ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Cuota Mensual:</p>
                    <p class="font-bold">${{ number_format(auth()->user()->cliente->cuota_mensual ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Cobros Pendientes -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold mb-4">📋 Cobros Pendientes</h2>
            @if($cobrosPendientes->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Período</th>
                            <th class="p-3 text-left">Monto</th>
                            <th class="p-3 text-left">Mora</th>
                            <th class="p-3 text-left">Vencimiento</th>
                            <th class="p-3 text-left">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cobrosPendientes as $cobro)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $cobro->periodo }}</td>
                            <td class="p-3">${{ number_format($cobro->monto, 2) }}</td>
                            <td class="p-3">${{ number_format($cobro->mora, 2) }}</td>
                            <td class="p-3">{{ $cobro->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded text-white text-sm
                                    @if($cobro->estado === 'vencido') bg-red-500
                                    @else bg-yellow-500
                                    @endif">
                                    {{ ucfirst($cobro->estado) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-green-600 font-bold">✓ ¡No tienes cobros pendientes!</p>
            @endif
        </div>

        <!-- Historial de Pagos -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">📜 Historial de Pagos</h2>
            @if($cobrosPagados->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Período</th>
                            <th class="p-3 text-left">Monto</th>
                            <th class="p-3 text-left">Fecha Pago</th>
                            <th class="p-3 text-left">Método</th>
                            <th class="p-3 text-left">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cobrosPagados as $cobro)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $cobro->periodo }}</td>
                            <td class="p-3">${{ number_format($cobro->monto + $cobro->mora, 2) }}</td>
                            <td class="p-3">{{ $cobro->fecha_pago->format('d/m/Y H:i') }}</td>
                            <td class="p-3">{{ $cobro->metodo_pago ?? 'N/A' }}</td>
                            <td class="p-3">
                                <a href="{{ route('cobros.descargar-comprobante', $cobro) }}" class="text-blue-600 hover:underline">
                                    Descargar Comprobante
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-600">Sin historial de pagos</p>
            @endif
        </div>
    </div>
</x-layouts.admin>
