<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department');
            $table->string('location');
            $table->string('type')->default('Full-time');
            $table->string('experience')->nullable();
            $table->date('posted_at')->nullable();
            $table->date('application_deadline')->nullable();
            $table->unsignedInteger('vacancy')->default(1);
            $table->text('summary')->nullable();
            $table->longText('overview')->nullable();
            $table->json('educational_qualifications')->nullable();
            $table->json('experience_details')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('requirements')->nullable();
            $table->json('nice_to_have')->nullable();
            $table->json('benefits')->nullable();
            $table->string('apply_email')->nullable();
            $table->json('contact_phones')->nullable();
            $table->text('application_instruction')->nullable();
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('serial_no')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_jobs');
    }
};
