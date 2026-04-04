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
        Schema::table('properties', function (Blueprint $table) {
            $table->index('bathrooms');
            $table->index('views_count');
            $table->index(['property_type_id', 'status']);
            $table->index(['area_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['bathrooms']);
            $table->dropIndex(['views_count']);
            $table->dropIndex(['property_type_id', 'status']);
            $table->dropIndex(['area_id', 'status']);
        });
    }
};
