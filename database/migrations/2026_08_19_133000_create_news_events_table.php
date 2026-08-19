<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->default(1)->index();
            $table->foreignId('language_id')->default(1)->index();
            $table->string('title');
            $table->string('slug');
            $table->date('event_date');
            $table->string('location');
            $table->string('image')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_href')->nullable();
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
        Schema::dropIfExists('news_events');
    }
};
