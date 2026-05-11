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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('image')->nullable()->after('logo');
            $table->string('domain')->nullable()->after('image');
            $table->text('caption')->nullable()->after('domain');
            $table->boolean('is_seeded')->default(true)->after('is_visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['image', 'domain', 'caption', 'is_seeded']);
        });
    }
};
