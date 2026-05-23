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
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['about_us_image', 'about_us_title', 'about_us_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('about_us_image')->nullable()->after('contact_description');
            $table->string('about_us_title')->nullable()->after('about_us_image');
            $table->text('about_us_description')->nullable()->after('about_us_title');
        });
    }
};
