<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('login_histories')) {
            Schema::create('login_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('device', 100)->nullable();
                $table->string('browser', 100)->nullable();
                $table->string('platform', 100)->nullable();
                $table->string('location', 255)->nullable();
                $table->timestamp('logged_in_at')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
