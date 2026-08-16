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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
             $table->foreignId('branch_id')->default(1)->index();
            $table->foreignId('language_id')->default(1)->index();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->double('lat')->nullable();
            $table->double('lang')->nullable();
            $table->text('map')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('whatsapp_number')->nullable();
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
        Schema::dropIfExists('contact_us');
    }
};
