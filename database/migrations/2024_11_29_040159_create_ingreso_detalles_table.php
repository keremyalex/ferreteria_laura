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
        Schema::create('ingreso_detalle', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('cantidad');
            $table->unsignedBigInteger('ingreso_id');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('ingreso_id')->references('id')->on('ingreso')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('producto')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso_detalles');
    }
};
