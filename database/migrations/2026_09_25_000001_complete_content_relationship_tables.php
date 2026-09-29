<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            if (!Schema::hasColumn('tags', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('tags', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }

            if (!Schema::hasColumn('tags', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('content_category', function (Blueprint $table) {
            if (!Schema::hasColumn('content_category', 'content_id')) {
                $table->foreignId('content_id')
                    ->after('id')
                    ->constrained('contents')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('content_category', 'category_id')) {
                $table->foreignId('category_id')
                    ->after('content_id')
                    ->constrained('categories')
                    ->cascadeOnDelete();
            }

            $table->unique(['content_id', 'category_id']);
        });

        Schema::table('content_tag', function (Blueprint $table) {
            if (!Schema::hasColumn('content_tag', 'content_id')) {
                $table->foreignId('content_id')
                    ->after('id')
                    ->constrained('contents')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('content_tag', 'tag_id')) {
                $table->foreignId('tag_id')
                    ->after('content_id')
                    ->constrained('tags')
                    ->cascadeOnDelete();
            }

            $table->unique(['content_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::table('content_tag', function (Blueprint $table) {
            if (Schema::hasColumn('content_tag', 'tag_id')) {
                $table->dropConstrainedForeignId('tag_id');
            }

            if (Schema::hasColumn('content_tag', 'content_id')) {
                $table->dropConstrainedForeignId('content_id');
            }
        });

        Schema::table('content_category', function (Blueprint $table) {
            if (Schema::hasColumn('content_category', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('content_category', 'content_id')) {
                $table->dropConstrainedForeignId('content_id');
            }
        });

        Schema::table('tags', function (Blueprint $table) {
            if (Schema::hasColumn('tags', 'deleted_at')) {
                $table->dropSoftDeletes();
            }

            if (Schema::hasColumn('tags', 'slug')) {
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('tags', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
