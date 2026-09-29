<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('canonical_url', 2048)->nullable()->change();
            $table->string('robots', 100)->nullable()->after('canonical_url');
            $table->string('og_title', 60)->nullable()->after('robots');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image', 2048)->nullable()->after('og_description');
            $table->string('twitter_card', 50)->nullable()->after('og_image');
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn([
                'robots',
                'og_title',
                'og_description',
                'og_image',
                'twitter_card',
            ]);

            $table->string('canonical_url')->nullable()->change();
        });
    }
};
