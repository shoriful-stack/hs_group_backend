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
        Schema::create('service_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();
            $table->integer('serial_no');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_processes');
    }
};
