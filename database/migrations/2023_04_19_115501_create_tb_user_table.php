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
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('role')->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->string('motto')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('language')->nullable();
            $table->string('activity')->nullable();
            $table->integer('fullday_tour')->nullable();
            $table->integer('morning_city_tour')->nullable();
            $table->integer('city_tour')->nullable();
            $table->integer('night_tour')->nullable();
            $table->integer('airport_transfer_price')->nullable();
            $table->integer('price')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->string('token')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
