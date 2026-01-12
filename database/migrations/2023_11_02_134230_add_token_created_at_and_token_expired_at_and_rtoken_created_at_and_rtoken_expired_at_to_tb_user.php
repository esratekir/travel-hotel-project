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
        Schema::table('tb_user', function (Blueprint $table) {
            $table->timestamp('token_created_at')->nullable();
            $table->timestamp('token_expired_at')->nullable();
            $table->timestamp('rtoken_created_at')->nullable();
            $table->timestamp('rtoken_expired_at')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_user', function (Blueprint $table) {
            //
        });
    }
};
