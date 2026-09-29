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
        Schema::create('contents', function (Blueprint $table) {

            $table->id();

            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();

            // Content Type
            $table->enum('content_type', [
                'blog',
                'service',
                'article',
                'page',
            ]);

            // Short Description
            $table->text('excerpt')->nullable();

            // Main Content
            $table->longText('content');

            // Images
            $table->string('featured_image')->nullable();
            $table->string('banner_image')->nullable();

            // Author
            $table->foreignId('author_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Status
            $table->enum('status', [
                'draft',
                'published',
                'scheduled',
                'archived',
            ])->default('draft');

            // Publish Information
            $table->timestamp('published_at')->nullable();

            // Options
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_comments')->default(true);

            // Statistics
            $table->unsignedBigInteger('view_count')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            // Laravel
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('content_type');
            $table->index('status');
            $table->index('published_at');
            $table->index('author_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};