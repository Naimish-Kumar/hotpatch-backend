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
        Schema::create('channels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->string('color')->nullable();
            $table->boolean('auto_rollout')->default(false);
            $table->unique(['app_id', 'slug']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
