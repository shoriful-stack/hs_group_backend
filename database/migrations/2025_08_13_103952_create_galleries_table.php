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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->default(1)->index();
            $table->foreignId('language_id')->default(1)->index();
            $table->foreignId('gallery_category_id')->default(1)->index();
            $table->enum('type',['image','video'])->default('image');
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('video_link')->nullable();
            $table->tinyInteger('serial')->default(1);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('galleries');
    }
};
