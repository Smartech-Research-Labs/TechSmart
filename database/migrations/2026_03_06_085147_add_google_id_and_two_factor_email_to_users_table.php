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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->string('two_factor_email_code')->nullable()->after('two_factor_confirmed_at');
            $table->timestamp('two_factor_email_expires_at')->nullable()->after('two_factor_email_code');
            $table->boolean('two_factor_email_enabled')->default(true)->after('two_factor_email_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'two_factor_email_code', 'two_factor_email_expires_at', 'two_factor_email_enabled']);
        });
    }
};
