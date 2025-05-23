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
            $table->decimal('horas_extras', 5, 2)->nullable()->after('updated_at'); // o ajusta la posición
        });
    }

    public function down()
    {
        Schema::table('registro_asistencias', function (Blueprint $table) {
            $table->dropColumn('horas_extras');
        });
    }
};
