<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('medidores', 'ubicacion')) {
            Schema::table('medidores', function (Blueprint $table) {
                $table->string('ubicacion')->default('Principal')->after('numero_medidor');
            });
        }

        if (!Schema::hasColumn('medidores', 'cuota_mensual')) {
            Schema::table('medidores', function (Blueprint $table) {
                $table->decimal('cuota_mensual', 10, 2)->default(10.00)->after('ubicacion');
            });
        }
    }

    public function down(): void
    {
        Schema::table('medidores', function (Blueprint $table) {
            $table->dropColumn(['ubicacion', 'cuota_mensual']);
        });
    }
};