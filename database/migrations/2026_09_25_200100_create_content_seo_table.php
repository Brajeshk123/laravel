<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_seo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')
                ->constrained('contents')
                ->cascadeOnDelete();
            $table->string('meta_title', 60)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url', 2048)->nullable();
            $table->string('robots', 100)->nullable();
            $table->string('og_title', 60)->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image', 2048)->nullable();
            $table->string('twitter_card', 50)->nullable();
            $table->timestamps();

            $table->unique('content_id');
        });

        DB::table('contents')
            ->where(function ($query) {
                $query->whereNotNull('meta_title')
                    ->orWhereNotNull('meta_description')
                    ->orWhereNotNull('meta_keywords')
                    ->orWhereNotNull('canonical_url');
            })
            ->orderBy('id')
            ->chunkById(100, function ($contents) {
                foreach ($contents as $content) {
                    DB::table('content_seo')->updateOrInsert(
                        ['content_id' => $content->id],
                        [
                            'meta_title' => $content->meta_title,
                            'meta_description' => $content->meta_description,
                            'meta_keywords' => $content->meta_keywords,
                            'canonical_url' => $content->canonical_url,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_seo');
    }
};
