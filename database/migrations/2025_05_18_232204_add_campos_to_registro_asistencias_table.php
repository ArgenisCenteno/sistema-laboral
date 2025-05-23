<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registro_asistencias', function (Blueprint $table) {
            $table->decimal('horas_trabajadas', 5, 2)->nullable();
            $table->text('observacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('registro_asistencias', function (Blueprint $table) {
            $table->dropColumn('horas_trabajadas');
            $table->dropColumn('observacion');
        });
    }
};
