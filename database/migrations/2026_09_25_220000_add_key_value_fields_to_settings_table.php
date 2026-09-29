<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->nullable()->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string');
                $table->string('group')->default('general');
                $table->timestamps();
            });

            return;
        }

        Schema::table('settings', function (Blueprint $table) {
            if (! Schema::hasColumn('settings', 'key')) {
                $table->string('key')->nullable()->unique()->after('id');
            }

            if (! Schema::hasColumn('settings', 'value')) {
                $table->text('value')->nullable()->after('key');
            }

            if (! Schema::hasColumn('settings', 'type')) {
                $table->string('type')->default('string')->after('value');
            }

            if (! Schema::hasColumn('settings', 'group')) {
                $table->string('group')->default('general')->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'group')) {
                $table->dropColumn('group');
            }

            if (Schema::hasColumn('settings', 'type')) {
                $table->dropColumn('type');
            }

            if (Schema::hasColumn('settings', 'value')) {
                $table->dropColumn('value');
            }

            if (Schema::hasColumn('settings', 'key')) {
                $table->dropUnique(['key']);
                $table->dropColumn('key');
            }
        });
    }
};
