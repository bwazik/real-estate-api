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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 15, 2)->index();
            $table->foreignId('property_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->integer('bedrooms')->index();
            $table->decimal('bathrooms', 4, 1);
            $table->decimal('area_size', 10, 2)->index();
            $table->integer('floor_number')->nullable();
            $table->integer('year_built')->nullable();
            $table->boolean('is_furnished')->default(false);
            $table->enum('status', ['available', 'reserved', 'sold', 'rented', 'unavailable'])->index();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('views_count')->default(0);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
