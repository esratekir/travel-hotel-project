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
        Schema::create('deleted_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->nullable();
            $table->integer('sender_id')->nullable();
            $table->integer('recipient_id')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_messages');
    }
};
