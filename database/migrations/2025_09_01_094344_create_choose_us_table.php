<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'choose_us', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'branch_id' )->default( 1 )->index();
            $table->foreignId( 'language_id' )->default( 1 )->index();
            $table->string( 'title' );
            $table->string( 'image' )->nullable();
            $table->text( 'content' )->nullable();
            $table->json( 'features' )->nullable();
            $table->foreignId( 'created_by' )->nullable();
            $table->foreignId( 'updated_by' )->nullable();
            $table->foreignId( 'deleted_by' )->nullable();
            $table->timestamp( 'deleted_at' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'choose_us' );
    }
};
