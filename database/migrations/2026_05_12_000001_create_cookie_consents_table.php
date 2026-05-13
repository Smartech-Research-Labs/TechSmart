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
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id')->nullable()->unique(); // Unique identifier for visitor (device/browser fingerprint or IP)
            $table->string('email')->nullable()->index(); // Email if user is logged in or provided
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            // Cookie preferences
            $table->boolean('necessary_cookies')->default(true); // Always true
            $table->boolean('analytics_cookies')->default(false);
            $table->boolean('marketing_cookies')->default(false);
            $table->boolean('accept_all')->default(false);
            
            // Tracking
            $table->string('source')->nullable(); // Where they came from (homepage, etc)
            $table->timestamp('consent_date')->useCurrent();
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('expires_at')->nullable(); // When consent expires (usually 12 months)
            
            // Foreign key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
            
            // Indexes for analytics
            $table->index('created_at');
            $table->index(['analytics_cookies', 'marketing_cookies']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
    }
};
