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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->default(1)->index();
            $table->tinyInteger('section_enable')->default(1);
            $table->tinyInteger('brand_enable')->default(1);
            $table->tinyInteger('blog_enable')->default(1);
            $table->tinyInteger('video_enable')->default(1);
            $table->string('video_url')->nullable();
            $table->string('video_thumb')->nullable();
            $table->string('since_image')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
