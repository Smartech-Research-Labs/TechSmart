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
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('icon')->nullable();          // e.g. "Stethoscope", "Factory"
            $table->string('image')->nullable();          // Hero / card image URL
            $table->string('banner_image')->nullable();   // Detail page hero banner
            $table->json('sub_sectors')->nullable();      // [{name, description, icon}]
            $table->json('process_steps')->nullable();    // [{title, description, icon}]
            $table->json('features')->nullable();         // [{title, description}]
            $table->json('stats')->nullable();            // [{value, label}]
            $table->string('cta_title')->nullable();
            $table->string('cta_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
