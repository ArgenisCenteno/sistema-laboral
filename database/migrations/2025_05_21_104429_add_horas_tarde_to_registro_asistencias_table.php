<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('registro_asistencias', function (Blueprint $table) {
            $table->decimal('horas_tarde', 5, 2)->nullable()->after('horas_extras');
            // Si prefieres precisión en minutos:
            $table->integer('minutos_tarde')->nullable()->after('horas_extras');
        });
    }

    public function down()
    {
        Schema::table('registro_asistencias', function (Blueprint $table) {
            $table->dropColumn('horas_tarde');
            $table->dropColumn('minutos_tarde');
        });
    }
};
