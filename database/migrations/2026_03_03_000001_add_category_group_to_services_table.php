<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('category_group')->nullable()->after('category');
            $table->decimal('price_from', 10, 2)->nullable()->after('category_group');
            $table->string('price_label')->nullable()->after('price_from');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['category_group', 'price_from', 'price_label']);
        });
    }
};
