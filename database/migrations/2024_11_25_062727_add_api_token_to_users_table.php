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
            // Check if the column already exists before adding it
            if (!Schema::hasColumn('users', 'api_token')) {
                $table->string('api_token', 80)->unique()->nullable()->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'api_token')) {
                $table->dropColumn('api_token');
            }
        });
    }
};
