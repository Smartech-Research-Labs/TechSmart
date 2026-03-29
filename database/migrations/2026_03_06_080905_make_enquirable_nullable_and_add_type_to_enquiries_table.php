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
        Schema::table('enquiries', function (Blueprint $table) {
            // Add type column for generic forms (contact, quote, consultation, service_enquiry, product_enquiry)
            $table->string('type')->default('general')->after('company');
            // Add subject column for contact forms
            $table->string('subject')->nullable()->after('type');
            // Make enquirable fields nullable for generic contact/quote forms
            $table->string('enquirable_type')->nullable()->change();
            $table->unsignedBigInteger('enquirable_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn(['type', 'subject']);
            $table->string('enquirable_type')->nullable(false)->change();
            $table->unsignedBigInteger('enquirable_id')->nullable(false)->change();
        });
    }
};
