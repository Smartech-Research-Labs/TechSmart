<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: This migration is intentionally empty. The key-value settings table
     * is created by the 2026_02_23_092509_create_settings_table migration.
     */
    public function up(): void
    {
        // Intentionally left empty — see 2026_02_23 migration for key-value settings table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
