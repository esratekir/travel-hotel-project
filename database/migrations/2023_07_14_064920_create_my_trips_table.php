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
        Schema::create('my_trips', function (Blueprint $table) {
            $table->id();
            $table->integer('guide_id')->nullable();
            $table->integer('destination')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('number_of')->nullable();
            $table->string('local_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_trips');
    }
};
