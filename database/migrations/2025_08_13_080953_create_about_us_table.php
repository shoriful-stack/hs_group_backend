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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
             $table->foreignId('branch_id')->default(1)->index();
            $table->foreignId('language_id')->default(1)->index();
            $table->tinyInteger('type')->default(0)->comment('1=Perspective, 2=our values, 3=Continuous improvement');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('serial_no')->default(1);
            $table->tinyInteger('status')->default(1)->comment('0=inactive,1=active');
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
        Schema::dropIfExists('about_us');
    }
};
