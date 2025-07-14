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
        Schema::create('hotel_room_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hoteles')->cascadeOnDelete();
            $table->enum('tipo_habitacion', ['ESTANDAR', 'JUNIOR', 'SUITE']);
            $table->enum('acomodacion', ['SENCILLA', 'DOBLE', 'TRIPLE', 'CUADRUPLE']);
            $table->unsignedInteger('cantidad');
            $table->unique(['hotel_id', 'tipo_habitacion', 'acomodacion']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_room_configs');
    }
};
