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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('password_hash'); // Go used PasswordHash
            $table->string('display_name')->nullable();
            $table->string('avatar_url', 512)->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_super_admin')->default(false);
            $table->string('verification_token')->nullable();
            $table->string('reset_password_token')->nullable();
            $table->timestamp('reset_password_expires_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        Schema::create('refresh_tokens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('token_hash', 64)->unique();
            $table->timestamp('expires_at');
            $table->boolean('revoked')->default(false);
            $table->timestamps();
        });

        Schema::create('apps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('platform', 50);
            $table->string('api_key', 64)->unique();
            $table->string('encryption_key', 64)->nullable();
            $table->foreignUuid('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('tier', 20)->default('free');
            $table->string('stripe_customer_id', 100)->nullable();
            $table->string('stripe_subscription_id', 100)->nullable();
            $table->string('subscription_status', 20)->default('active');
            $table->timestamp('subscription_end')->nullable();
            $table->timestamps();
        });

        Schema::create('releases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('version', 50);
            $table->string('channel', 50)->default('production');
            $table->text('bundle_url');
            $table->text('object_key');
            $table->string('hash', 64);
            $table->text('signature');
            $table->boolean('mandatory')->default(false);
            $table->smallInteger('rollout_percentage')->default(100);
            $table->boolean('is_encrypted')->default(false);
            $table->boolean('is_patch')->default(false);
            $table->string('base_version', 50)->nullable();
            $table->string('key_id', 50)->nullable();
            $table->bigInteger('size')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('device_id')->unique();
            $table->foreignUuid('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('platform', 50);
            $table->string('current_version', 50)->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
        });

        Schema::create('installations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('device_id')->constrained('devices')->onDelete('cascade');
            $table->foreignUuid('release_id')->constrained('releases')->onDelete('cascade');
            $table->string('status', 20);
            $table->boolean('is_patch')->default(false);
            $table->bigInteger('download_size')->default(0);
            $table->timestamp('installed_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('patches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('release_id')->constrained('releases')->onDelete('cascade');
            $table->string('base_version', 50);
            $table->text('patch_url');
            $table->text('object_key');
            $table->string('hash', 64);
            $table->text('signature');
            $table->bigInteger('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patches');
        Schema::dropIfExists('installations');
        Schema::dropIfExists('devices');
        Schema::dropIfExists('releases');
        Schema::dropIfExists('apps');
        Schema::dropIfExists('refresh_tokens');
        Schema::dropIfExists('users');
    }
};
