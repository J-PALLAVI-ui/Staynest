<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', ['safety', 'room', 'food', 'utilities', 'rules']);
            $table->string('icon')->nullable(); // e.g. "shield-check" for heroicons
            $table->timestamps();
        });

        Schema::create('pg_amenity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained()->onDelete('cascade');
            $table->foreignId('amenity_id')->constrained()->onDelete('cascade');
            $table->unique(['pg_id', 'amenity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pg_amenity');
        Schema::dropIfExists('amenities');
    }
};
