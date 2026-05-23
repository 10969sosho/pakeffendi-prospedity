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
            // Property type and status
            $table->string('property_type')->nullable()->after('description'); // villas, houses, apartments, land, etc.
            $table->string('property_status')->nullable()->after('property_type'); // freehold, leasehold
            
            // Price fields
            $table->decimal('price_monthly', 15, 2)->nullable()->after('price');
            $table->decimal('price_yearly', 15, 2)->nullable()->after('price_monthly');
            $table->decimal('price_freehold', 15, 2)->nullable()->after('price_yearly');
            $table->decimal('price_leasehold', 15, 2)->nullable()->after('price_freehold');
            
            // Leasehold period
            $table->integer('leasehold_period')->nullable()->after('price_leasehold'); // in years
            
            // Flags for available pricing options
            $table->boolean('has_monthly')->default(false)->after('leasehold_period');
            $table->boolean('has_yearly')->default(false)->after('has_monthly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'property_type',
                'property_status',
                'price_monthly',
                'price_yearly',
                'price_freehold',
                'price_leasehold',
                'leasehold_period',
                'has_monthly',
                'has_yearly',
            ]);
        });
    }
};
