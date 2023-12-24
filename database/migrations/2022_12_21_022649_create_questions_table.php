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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->longText('body');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('category_id')->default(0);
    
            // Foreign key constraint
            $table->foreign('category_id')->references('id')->on('questions_categories')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }    
};