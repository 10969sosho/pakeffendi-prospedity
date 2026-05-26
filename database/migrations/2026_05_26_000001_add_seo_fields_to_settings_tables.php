<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('home_settings', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('hero_logo');
            }
            if (!Schema::hasColumn('home_settings', 'seo_description')) {
                $table->text('seo_description')->nullable()->after('seo_title');
            }
            if (!Schema::hasColumn('home_settings', 'seo_keywords')) {
                $table->text('seo_keywords')->nullable()->after('seo_description');
            }
        });

        Schema::table('about_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('about_settings', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('page_description');
            }
            if (!Schema::hasColumn('about_settings', 'seo_description')) {
                $table->text('seo_description')->nullable()->after('seo_title');
            }
            if (!Schema::hasColumn('about_settings', 'seo_keywords')) {
                $table->text('seo_keywords')->nullable()->after('seo_description');
            }
        });

        Schema::table('contact_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_settings', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('maps_url');
            }
            if (!Schema::hasColumn('contact_settings', 'seo_description')) {
                $table->text('seo_description')->nullable()->after('seo_title');
            }
            if (!Schema::hasColumn('contact_settings', 'seo_keywords')) {
                $table->text('seo_keywords')->nullable()->after('seo_description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });

        Schema::table('about_settings', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });

        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });
    }
};
