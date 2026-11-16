<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('background_image')->nullable()->change();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Rows created while these columns were nullable may hold NULL; backfill them
        // so the columns can be made NOT NULL again without MySQL error 1138.
        DB::table('sliders')->whereNull('background_image')->update(['background_image' => '']);
        DB::table('clients')->whereNull('logo')->update(['logo' => '']);

        Schema::table('sliders', function (Blueprint $table) {
            $table->string('background_image')->nullable(false)->change();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('logo')->nullable(false)->change();
        });
    }
};
