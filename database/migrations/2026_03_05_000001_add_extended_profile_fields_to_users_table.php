<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'display_name')) {
                $table->string('display_name', 100)->nullable()->after('name');
            }
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar', 500)->nullable()->after('bio');
            }
            if (! Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('avatar');
            }
            if (! Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 20)->nullable()->after('date_of_birth');
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->string('address', 500)->nullable()->after('gender');
            }
            if (! Schema::hasColumn('users', 'city')) {
                $table->string('city', 100)->nullable()->after('address');
            }
            if (! Schema::hasColumn('users', 'country')) {
                $table->string('country', 100)->nullable()->after('city');
            }
            if (! Schema::hasColumn('users', 'timezone')) {
                $table->string('timezone', 50)->nullable()->default('Africa/Nairobi')->after('country');
            }
            if (! Schema::hasColumn('users', 'language')) {
                $table->string('language', 10)->nullable()->default('en')->after('timezone');
            }
            if (! Schema::hasColumn('users', 'social_links')) {
                $table->json('social_links')->nullable()->after('language');
            }
            if (! Schema::hasColumn('users', 'notification_preferences')) {
                $table->json('notification_preferences')->nullable()->after('social_links');
            }
            if (! Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('notification_preferences');
            }
            if (! Schema::hasColumn('users', 'last_login_ip')) {
                $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status', 20)->default('active')->after('last_login_ip');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'display_name', 'avatar', 'date_of_birth', 'gender',
                'address', 'city', 'country', 'timezone', 'language',
                'social_links', 'notification_preferences',
                'last_login_at', 'last_login_ip', 'status',
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
