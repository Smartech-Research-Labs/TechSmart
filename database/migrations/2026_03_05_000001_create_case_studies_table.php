<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_logo')->nullable();
            $table->string('industry')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->json('service_ids')->nullable();
            $table->longText('challenge')->nullable();
            $table->longText('solution')->nullable();
            $table->longText('results')->nullable();
            $table->json('metrics')->nullable();
            $table->json('technologies')->nullable();
            $table->text('testimonial_quote')->nullable();
            $table->string('testimonial_author')->nullable();
            $table->string('testimonial_role')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
