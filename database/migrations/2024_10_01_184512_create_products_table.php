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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('concept_id'); // Foreign key from concepts table
            $table->unsignedBigInteger('yarn_id'); // Foreign key from yarns table
            $table->unsignedBigInteger('area_id'); // Foreign key from areas table
            $table->unsignedBigInteger('fabric_id'); // Foreign key from fabrics table
            $table->integer('height')->comment('Height in inches'); // For the height (1-100 inches)
            $table->unsignedBigInteger('technical_concept_id'); // Foreign key from technical_concepts table
            $table->unsignedBigInteger('panna_id'); // Foreign key from pannas table
            $table->decimal('rate', 8, 2); // For the rate (decimal value)
            $table->date('date'); // For the date selector
            $table->string('stitches')->nullable(); // Foreign key for stitches (nullable if needed)
            $table->unsignedBigInteger('use_in_id'); // Foreign key from use_ins table
            $table->string('design_name'); // Design name (text)

            // Foreign key constraints
            $table->foreign('concept_id')->references('id')->on('concept')->onDelete('cascade');
            $table->foreign('yarn_id')->references('id')->on('yarns')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('fabric_id')->references('id')->on('fabrics')->onDelete('cascade');
            $table->foreign('technical_concept_id')->references('id')->on('technically_concepts')->onDelete('cascade');
            $table->foreign('panna_id')->references('id')->on('pannas')->onDelete('cascade');
            $table->foreign('use_in_id')->references('id')->on('use_ins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
