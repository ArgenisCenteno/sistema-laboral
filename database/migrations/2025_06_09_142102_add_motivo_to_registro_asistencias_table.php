<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registro_asistencias', function (Blueprint $table) {
            $table->string('motivo_salida_anticipada')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('registro_asistencias', function (Blueprint $table) {
            $table->dropColumn('motivo_salida_anticipada'); 
        });
    }
};
