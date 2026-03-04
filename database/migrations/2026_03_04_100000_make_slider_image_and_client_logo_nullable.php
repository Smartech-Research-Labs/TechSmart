<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('background_image')->nullable(false)->change();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('logo')->nullable(false)->change();
        });
    }
};
