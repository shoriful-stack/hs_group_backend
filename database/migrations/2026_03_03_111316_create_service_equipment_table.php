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
        Schema::create('service_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();
            $table->foreignId('service_equipment_category_id')
                ->constrained('service_equipment_categories')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('icon')->nullable();
            $table->timestamps();

            $table->index(['service_equipment_category_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_equipment');
    }
};
