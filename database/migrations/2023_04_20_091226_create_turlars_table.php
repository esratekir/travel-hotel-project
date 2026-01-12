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
        Schema::create('turlars', function (Blueprint $table) {
            $table->id();
            $table->integer('country')->nullable();
            $table->integer('day')->nullable();
            $table->integer('person')->nullable();
            $table->string('tour_title')->nullable();
            $table->string('star')->nullable();
            $table->string('price')->nullable();
            $table->text('fiyat_dahil')->nullable();
            $table->text('fiyat_dahil_degil')->nullable();
            $table->string('kisi_basi')->nullable();
            $table->date('tur_tarihi')->nullable();
            $table->string('cift_kisilik_oda')->nullable();
            $table->string('ilave_yatak')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turlars');
    }
};
