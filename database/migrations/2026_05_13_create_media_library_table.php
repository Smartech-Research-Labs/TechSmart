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
        Schema::create('media_library', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Original filename
            $table->string('path'); // Storage path
            $table->string('url'); // Access URL
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            
            // SEO Metadata
            $table->string('title')->nullable(); // SEO title
            $table->text('description')->nullable(); // SEO description
            $table->string('alt_text')->nullable(); // Alt text for accessibility
            $table->text('caption')->nullable(); // Image caption
            
            // Additional metadata
            $table->string('image_width')->nullable();
            $table->string('image_height')->nullable();
            $table->string('folder')->default('media'); // Category/folder
            
            // Usage tracking
            $table->integer('usage_count')->default(0);
            $table->json('used_in')->nullable(); // JSON array of where it's used
            
            $table->timestamps();
            
            $table->index('folder');
            $table->index('created_at');
        });

        Schema::create('industry_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('media_id')->constrained('media_library')->cascadeOnDelete();
            $table->string('type')->default('image'); // 'image', 'banner', 'icon', etc.
            $table->timestamps();
            
            $table->unique(['industry_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry_media');
        Schema::dropIfExists('media_library');
    }
};
