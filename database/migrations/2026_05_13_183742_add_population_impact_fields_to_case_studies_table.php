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
        Schema::table('case_studies', function (Blueprint $table) {
            // Add population impact fields
            $table->string('population_impacted')->nullable()->comment('e.g., "50,000+"');
            $table->text('impact_description')->nullable()->comment('Description of the impact made');
            $table->string('sector')->nullable()->comment('Industry/sector of the project');
            $table->string('case_study_slug')->nullable()->unique()->comment('URL slug for case study link');
            
            // Add indexes for better query performance
            $table->index('sector');
            $table->index('case_study_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_studies', function (Blueprint $table) {
            $table->dropIndex(['sector']);
            $table->dropIndex(['case_study_slug']);
            $table->dropColumn(['population_impacted', 'impact_description', 'sector', 'case_study_slug']);
        });
    }
};
