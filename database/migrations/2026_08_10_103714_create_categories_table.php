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
        Schema::create('categories', function (Blueprint $table) {

            $table->id();

            // Parent Category
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();

            // Description
            $table->text('description')->nullable();

            // Image & Icon
            $table->string('image')->nullable();
            $table->string('icon')->nullable();

            // Ordering
            $table->integer('sort_order')->default(0);

            // Status
            $table->boolean('status')->default(true);

            // Laravel
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('parent_id');
            $table->index('status');
            $table->index('sort_order');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};