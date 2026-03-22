<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('periodo')->comment('Ej: 2026-03');
            $table->decimal('lectura_anterior', 10, 2)->default(0);
            $table->decimal('lectura_actual', 10, 2);
            $table->decimal('metros_consumidos', 10, 2);
            $table->decimal('monto_cobro', 10, 2);
            $table->date('fecha_lectura');
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->unique(['cliente_id', 'periodo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturas');
    }
};
