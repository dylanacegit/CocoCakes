<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->renameColumn('content', 'description');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->json('options')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['slug', 'options']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->renameColumn('description', 'content');
        });
    }
};
