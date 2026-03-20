<!DOCTYPE html>
<html>
<head>
    <title>Comprobante de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h3 {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 0 0 10px 0;
            border-left: 4px solid #007bff;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            width: 40%;
        }
        .value {
            width: 60%;
            text-align: right;
        }
        .total-section {
            background-color: #f9f9f9;
            padding: 15px;
            border: 2px solid #007bff;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .paid-stamp {
            color: green;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>💧 SISTEMA DE AGUA POTABLE</h1>
        <p>Comprobante de Pago</p>
    </div>

    <div class="section">
        <h3>Información del Cliente</h3>
        <div class="row">
            <span class="label">Nombre:</span>
            <span class="value">{{ $cobro->cliente->nombre }}</span>
        </div>
        <div class="row">
            <span class="label">Dirección:</span>
            <span class="value">{{ $cobro->cliente->direccion }}</span>
        </div>
        <div class="row">
            <span class="label">Número de Medidor:</span>
            <span class="value">{{ $cobro->cliente->numero_medidor }}</span>
        </div>
    </div>

    <div class="section">
        <h3>Detalles del Pago</h3>
        <div class="row">
            <span class="label">Período:</span>
            <span class="value">{{ $cobro->periodo }}</span>
        </div>
        <div class="row">
            <span class="label">Monto Base:</span>
            <span class="value">${{ number_format($cobro->monto, 2) }}</span>
        </div>
        <div class="row">
            <span class="label">Mora:</span>
            <span class="value">${{ number_format($cobro->mora, 2) }}</span>
        </div>
        <div class="row">
            <span class="label">Fecha de Vencimiento:</span>
            <span class="value">{{ $cobro->fecha_vencimiento->format('d/m/Y') }}</span>
        </div>
        <div class="row">
            <span class="label">Fecha de Pago:</span>
            <span class="value">{{ $cobro->fecha_pago->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row">
            <span class="label">Método de Pago:</span>
            <span class="value">{{ $cobro->metodo_pago ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="total-section">
        <div class="total-row">
            <span>TOTAL PAGADO:</span>
            <span>${{ number_format($cobro->monto + $cobro->mora, 2) }}</span>
        </div>
        <div class="paid-stamp">✓ PAGADO</div>
    </div>

    @if($cobro->observaciones)
    <div class="section">
        <h3>Observaciones</h3>
        <p>{{ $cobro->observaciones }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Comprobante generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Referencia: Comprobante #{{ $cobro->id }}</p>
        <p>Gracias por su pago</p>
    </div>
</body>
</html>
