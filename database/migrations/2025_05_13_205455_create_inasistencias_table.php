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
        Schema::create('inasistencias', function (Blueprint $table) {
    $table->id();
    $table->foreignId('personal_id')->constrained('personal')->onDelete('cascade');
    $table->date('fecha');
    $table->string('motivo')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inasistencias');
    }
};
