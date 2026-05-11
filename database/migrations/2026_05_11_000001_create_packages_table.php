<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('tier_level')->nullable(); // Basic, Advanced, Pro, Enterprise
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_label')->nullable(); // e.g., "Starting from"
            $table->string('image')->nullable();
            $table->string('highlight_text')->nullable(); // e.g., "Perfect for startups"
            $table->json('features')->nullable(); // Array of features
            $table->json('includes')->nullable(); // Array of what's included
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_published');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
