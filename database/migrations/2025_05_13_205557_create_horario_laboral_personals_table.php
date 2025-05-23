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
        Schema::create('horario_laboral_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_id')->constrained('personal')->onDelete('cascade');
            $table->foreignId('horario_laboral_id')->constrained('horarios_laborales')->onDelete('cascade');
          //  $table->date('desde')->nullable(); // por si cambia de horario en una fecha
          //  $table->date('hasta')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_laboral_personals');
    }
};
