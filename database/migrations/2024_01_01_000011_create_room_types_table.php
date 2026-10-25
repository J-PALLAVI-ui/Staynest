<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('sharing'); // 1, 2, 3, 4
            $table->boolean('ac')->default(false);
            $table->integer('rent'); // monthly rent in INR
            $table->integer('deposit')->default(0);
            $table->integer('beds_total')->default(1);
            $table->integer('beds_free')->default(0);
            $table->boolean('meals_included')->default(false);
            $table->integer('electricity_extra')->default(0); // extra monthly charge
            $table->integer('laundry_extra')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
