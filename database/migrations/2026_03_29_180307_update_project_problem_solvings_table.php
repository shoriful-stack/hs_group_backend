<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_problem_solvings', function (Blueprint $table) {
            $table->dropColumn(['type', 'description']);

            $table->text('challenge')->nullable()->after('project_id');
            $table->text('solution')->nullable()->after('challenge');
        });
    }

    public function down(): void
    {
        Schema::table('project_problem_solvings', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1)->comment('0=challenge, 1=solution');
            $table->text('description')->nullable();

            $table->dropColumn(['challenge', 'solution']);
        });
    }
};
