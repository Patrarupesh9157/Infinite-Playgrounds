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
        Schema::create('game_likes', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade'); // Game reference
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User reference
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_likes');
    }
};
