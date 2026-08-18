<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('about_us') || Schema::hasColumn('about_us', 'images')) {
            return;
        }

        Schema::table('about_us', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('about_us') || ! Schema::hasColumn('about_us', 'images')) {
            return;
        }

        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
