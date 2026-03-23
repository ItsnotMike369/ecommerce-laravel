<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // All these columns are already present in create_users_table for fresh installs.
        // This migration only applies to existing databases that predate the consolidated schema.
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('name');
                $table->string('last_name')->nullable()->after('first_name');
                $table->tinyInteger('birth_month')->nullable()->after('last_name');
                $table->tinyInteger('birth_day')->nullable()->after('birth_month');
                $table->smallInteger('birth_year')->nullable()->after('birth_day');
                $table->string('gender')->nullable()->after('birth_year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['first_name', 'last_name', 'birth_month', 'birth_day', 'birth_year', 'gender'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
