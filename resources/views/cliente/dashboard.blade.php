@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header with Logout -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Portal del Cliente</h1>
            <p class="text-gray-600 mt-2">Bienvenido, {{ Auth::guard('cliente')->user()->nombre }}</p>
        </div>
        <form action="{{ route('cliente.logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-bold">
                Cerrar Sesión
            </button>
        </form>
    </div>

    <!-- Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-red-50 rounded-lg p-6 border border-red-200">
            <h2 class="text-lg font-semibold text-red-900">Saldo Pendiente</h2>
            <p class="text-3xl font-bold text-red-600 mt-2">${{ number_format($totalPendiente, 2) }}</p>
        </div>
        <div class="bg-green-50 rounded-lg p-6 border border-green-200">
            <h2 class="text-lg font-semibold text-green-900">Total Pagado</h2>
            <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($totalPagado, 2) }}</p>
        </div>
    </div>

    <!-- Datos del Cliente -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Información de la Cuenta</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Nombre</p>
                <p class="font-semibold">{{ Auth::guard('cliente')->user()->nombre }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Número de Medidor</p>
                <p class="font-semibold">{{ Auth::guard('cliente')->user()->numero_medidor }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Dirección</p>
                <p class="font-semibold">{{ Auth::guard('cliente')->user()->direccion }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Cuota Mensual</p>
                <p class="font-semibold">${{ number_format(Auth::guard('cliente')->user()->cuota_mensual, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Cobros Pendientes -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Cobros Pendientes</h2>
        
        @if($cobrosPendientes->isEmpty())
            <p class="text-gray-600 text-center py-8">No tienes cobros pendientes</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Período</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Monto</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Mora</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Total</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Estado</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cobrosPendientes as $cobro)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $cobro->periodo }}</td>
                            <td class="px-6 py-3">${{ number_format($cobro->monto, 2) }}</td>
                            <td class="px-6 py-3">${{ number_format($cobro->mora, 2) }}</td>
                            <td class="px-6 py-3 font-semibold">${{ number_format($cobro->monto + $cobro->mora, 2) }}</td>
                            <td class="px-6 py-3">
                                @if($cobro->estado === 'vencido')
                                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Vencido</span>
                                @else
                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 flex gap-2">
                                <button onclick="openPaymentModal({{ $cobro->id }}, {{ $cobro->monto + $cobro->mora }})" class="inline-block bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700">
                                    Pagar Online
                                </button>
                                <button onclick="openReceiptModal({{ $cobro->id }})" class="inline-block bg-purple-600 text-white px-3 py-2 rounded text-sm hover:bg-purple-700">
                                    Enviar Recibo
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Historial de Pagos -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Historial de Pagos</h2>
        
        @if($cobrosPagados->isEmpty())
            <p class="text-gray-600 text-center py-8">No hay pagos registrados</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Período</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Monto</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Fecha de Pago</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cobrosPagados as $cobro)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $cobro->periodo }}</td>
                            <td class="px-6 py-3">${{ number_format($cobro->monto + $cobro->mora, 2) }}</td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($cobro->fecha_pago)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('cobros.descargar-comprobante', $cobro) }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">Descargar Comprobante</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Modal: Pagar Online -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Pago Online</h3>
        <p class="text-gray-600 mb-4">Monto a pagar: <span id="paymentAmount" class="font-bold"></span></p>
        <p class="text-gray-600 mb-4">Función de pago online próximamente disponible.</p>
        <div class="flex gap-3">
            <button onclick="closePaymentModal()" class="flex-1 bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
            <button onclick="processOnlinePayment()" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Aceptar</button>
        </div>
    </div>
</div>

<!-- Modal: Enviar Recibo -->
<div id="receiptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Enviar Recibo de Pago</h3>
        <form id="receiptForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Cargar imagen del recibo</label>
                <input type="file" id="receiptFile" name="receipt" accept="image/*" required class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Observaciones (opcional)</label>
                <textarea id="receiptNotes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeReceiptModal()" class="flex-1 bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
                <button type="submit" class="flex-1 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Enviar</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentCobroId = null;

function openPaymentModal(cobroId, amount) {
    currentCobroId = cobroId;
    document.getElementById('paymentAmount').textContent = '$' + amount.toFixed(2);
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    currentCobroId = null;
}

function openReceiptModal(cobroId) {
    currentCobroId = cobroId;
    document.getElementById('receiptModal').classList.remove('hidden');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
    document.getElementById('receiptForm').reset();
    currentCobroId = null;
}

function processOnlinePayment() {
    alert('La funcionalidad de pago online será implementada próximamente.');
    closePaymentModal();
}

document.getElementById('receiptForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('La funcionalidad para enviar recibos será implementada próximamente.');
    closeReceiptModal();
});

// Cerrar modales al presionar Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentModal();
        closeReceiptModal();
    }
});
</script>

@endsection
