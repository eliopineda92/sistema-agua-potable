<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->date('fecha_cobro');
            $table->decimal('monto', 10, 2);
            $table->decimal('mora', 10, 2)->default(0);
            $table->enum('estado', ['pendiente', 'pagado', 'vencido'])->default('pendiente');
            $table->date('fecha_vencimiento');
            $table->date('fecha_pago')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cobros');
    }
};

