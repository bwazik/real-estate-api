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
            $table->enum('purpose', ['sale', 'rent', 'investment'])->after('price')->index();
            $table->unsignedTinyInteger('status')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->enum('status', ['available', 'reserved', 'sold', 'rented', 'unavailable'])->index()->change();
            $table->dropColumn('purpose');
        });
    }
};
