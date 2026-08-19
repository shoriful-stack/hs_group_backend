<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('author_id')->nullable()->after('category_id')->index();
            $table->text('excerpt')->nullable()->after('slug');
            $table->text('summary')->nullable()->after('excerpt');
            $table->boolean('featured')->default(false)->after('status')->index();
            $table->unsignedInteger('views')->default(0)->after('featured');
            $table->unsignedTinyInteger('reading_time')->nullable()->after('views');
            $table->string('pdf_file')->nullable()->after('image');
        });

        DB::statement('ALTER TABLE blogs MODIFY content LONGTEXT NULL');
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'author_id',
                'excerpt',
                'summary',
                'featured',
                'views',
                'reading_time',
                'pdf_file',
            ]);
        });

        DB::statement('ALTER TABLE blogs MODIFY content TEXT NULL');
    }
};
