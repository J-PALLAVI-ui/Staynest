<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pgs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('gender_type', ['boys', 'girls']);
            $table->string('area');
            $table->string('city')->default('Bangalore');
            $table->string('full_address')->nullable(); // hidden until enquiry
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'live', 'rejected', 'suspended'])->default('pending');
            $table->boolean('verified')->default(false);
            $table->string('verification_note')->nullable();

            // Girls-only safety fields
            $table->boolean('female_warden')->default(false);
            $table->string('curfew_time')->nullable();
            $table->string('visitor_policy')->nullable();
            $table->boolean('security_24x7')->default(false);
            $table->string('cctv_coverage')->nullable(); // e.g. "Common areas only"

            // Listing health
            $table->timestamp('last_updated')->nullable();
            $table->boolean('is_stale')->default(false); // cron sets after 30 days

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pgs');
    }
};
