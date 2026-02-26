<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sliders')) {
            return;
        }

        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'title')) {
                $table->string('title')->nullable()->after('image');
            }
            if (!Schema::hasColumn('sliders', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (!Schema::hasColumn('sliders', 'btn_text')) {
                $table->string('btn_text')->nullable()->after('description');
            }
            if (!Schema::hasColumn('sliders', 'btn_link')) {
                $table->string('btn_link')->nullable()->after('btn_text');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('sliders')) {
            return;
        }

        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'btn_link')) {
                $table->dropColumn('btn_link');
            }
            if (Schema::hasColumn('sliders', 'btn_text')) {
                $table->dropColumn('btn_text');
            }
            if (Schema::hasColumn('sliders', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('sliders', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};
