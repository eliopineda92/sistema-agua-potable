<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cobros', function (Blueprint $table) {
            $table->unsignedBigInteger('lectura_id')->nullable()->after('cliente_id');
            $table->foreign('lectura_id')->references('id')->on('lecturas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('cobros', function (Blueprint $table) {
            $table->dropForeign(['lectura_id']);
            $table->dropColumn('lectura_id');
        });
    }
};
