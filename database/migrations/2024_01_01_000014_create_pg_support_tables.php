<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained()->onDelete('cascade')->unique();
            $table->string('curfew')->nullable();         // e.g. "10:00 PM"
            $table->string('visitors')->nullable();       // e.g. "Allowed till 8 PM in common areas"
            $table->boolean('smoking_allowed')->default(false);
            $table->boolean('alcohol_allowed')->default(false);
            $table->boolean('cooking_allowed')->default(false);
            $table->string('pets_policy')->nullable();
            $table->string('noise_policy')->nullable();
            $table->text('other_rules')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating'); // 1-5
            $table->text('text')->nullable();
            $table->boolean('verified_resident')->default(false);
            $table->boolean('approved')->default(false);
            $table->timestamps();
            $table->unique(['pg_id', 'user_id']);
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('student_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'read', 'replied'])->default('new');
            $table->timestamp('address_revealed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pg_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained()->onDelete('cascade');
            $table->string('s3_path');
            $table->string('alt_text')->nullable();
            $table->boolean('is_cover')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pg_photos');
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('rules');
    }
};
