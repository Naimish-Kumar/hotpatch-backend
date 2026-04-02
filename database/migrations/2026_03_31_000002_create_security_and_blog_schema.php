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
        Schema::create('blogs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('author')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        Schema::create('api_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('key', 64)->unique();
            $table->string('prefix', 8);
            $table->timestamp('last_used')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('signing_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('name', 100);
            $table->text('public_key');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('actor')->nullable();
            $table->string('action');
            $table->string('entity_id')->nullable();
            $table->text('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('signing_keys');
        Schema::dropIfExists('api_keys');
        Schema::dropIfExists('blogs');
    }
};
