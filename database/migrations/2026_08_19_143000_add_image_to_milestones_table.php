<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('milestones', function (Blueprint $table) {
            if (! Schema::hasColumn('milestones', 'image')) {
                $table->string('image')->nullable()->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('milestones', function (Blueprint $table) {
            if (Schema::hasColumn('milestones', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
