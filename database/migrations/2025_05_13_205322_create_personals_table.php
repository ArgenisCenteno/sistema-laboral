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
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cedula')->unique();
            $table->string('rif')->nullable();
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->text('direccion');
            $table->uuid('qr_code')->unique(); 
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
