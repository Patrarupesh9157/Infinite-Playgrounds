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
        Schema::create('games', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name of the game
            $table->text('description')->nullable(); // Description of the game
            $table->text('html_code'); // HTML code for the game
            $table->text('css_code'); // CSS code for the game
            $table->text('js_code'); // JavaScript code for the game
            $table->json('images')->nullable(); // JSON to store multiple image URLs
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
