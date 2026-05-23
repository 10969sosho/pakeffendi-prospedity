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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('pic_ref_number')->nullable()->after('property_status');
            $table->string('pic_name')->nullable()->after('pic_ref_number');
            $table->string('pic_email')->nullable()->after('pic_name');
            $table->string('pic_whatsapp_number')->nullable()->after('pic_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['pic_ref_number', 'pic_name', 'pic_email', 'pic_whatsapp_number']);
        });
    }
};
