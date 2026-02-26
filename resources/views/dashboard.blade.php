
<x-layouts.admin :title="'Dashboard'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tarjetas resumen -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-gray-500 text-sm">Total Cobrado</h3>
                    <p class="text-2xl font-bold text-green-600">
                        ${{ number_format($total_cobrado, 2) }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-gray-500 text-sm">Total Pendiente</h3>
                    <p class="text-2xl font-bold text-yellow-600">
                        ${{ number_format($total_pendiente, 2) }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-gray-500 text-sm">Clientes en Mora</h3>
                    <p class="text-2xl font-bold text-red-600">
                        {{ $clientes_mora }}
                    </p>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-gray-500 text-sm">Total Clientes</h3>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ $total_clientes }}
                    </p>
                </div>
            </div>

            <!-- Botones módulos -->
            <div class="bg-white p-6 rounded shadow space-x-4">
                <a href="{{ route('clientes.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Clientes
                </a>

                <a href="{{ route('cobros.index') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Cobros
                </a>
            </div>

        </div>
    </div>
</x-layouts.admin>
