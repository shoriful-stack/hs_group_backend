<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->default(1)->index();
            $table->foreignId('language_id')->default(1)->index();
            $table->string('name');
            $table->string('slug');
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('serial_no')->default(1);
            $table->tinyInteger('status')->default(1)->comment('0=inactive,1=active');
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_authors');
    }
};
