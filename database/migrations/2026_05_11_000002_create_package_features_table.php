<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Emoji or icon class
            $table->boolean('is_highlighted')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index('package_id');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_features');
    }
};
