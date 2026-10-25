<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('area');
            $table->string('city')->default('Bangalore');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('pg_college_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained()->onDelete('cascade');
            $table->foreignId('college_id')->constrained()->onDelete('cascade');
            $table->integer('resident_count')->default(0); // owner-reported
            $table->timestamp('updated_at')->nullable();
            $table->unique(['pg_id', 'college_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pg_college_stats');
        Schema::dropIfExists('colleges');
    }
};
