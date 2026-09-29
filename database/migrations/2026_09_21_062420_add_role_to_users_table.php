<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations
    public function up(): void
    {
        // Add a new 'role' column to the 'users' table with a default value of 'user'
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')
                ->default('user')
                ->after('password');
        });
    }

    public function down(): void
    {
        // Remove the 'role' column from the 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
