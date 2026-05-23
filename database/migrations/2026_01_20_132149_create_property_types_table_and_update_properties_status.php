<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create property_types table
        Schema::create('property_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Seed initial property types
        $types = [
            ['name' => 'Villa', 'slug' => 'villas'],
            ['name' => 'House', 'slug' => 'houses'],
            ['name' => 'Apartment', 'slug' => 'apartments'],
            ['name' => 'Land', 'slug' => 'land'],
        ];

        foreach ($types as $type) {
            DB::table('property_types')->insert(array_merge($type, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 3. Update properties table structure and data
        
        // First, ensure no NULL property_status exists before making it default/non-nullable if we were to do that.
        // Even if we keep it nullable, we want existing NULLs to be AVAILABLE.
        DB::table('properties')
            ->whereNull('property_status')
            ->update(['property_status' => 'AVAILABLE']);

        Schema::table('properties', function (Blueprint $table) {
            // Add property_type_id
            $table->foreignId('property_type_id')->nullable()->after('property_type')->constrained('property_types')->nullOnDelete();
            
            // Change property_status default to DRAFT
            // We use change() here. If it fails due to missing DBAL, we might need a raw statement.
            // But Laravel 11+ supports native column modification for MySQL/MariaDB/Postgres.
            $table->string('property_status')->default('DRAFT')->change();
        });

        // 4. Migrate existing property types to property_type_id
        $propertyTypes = DB::table('property_types')->get();
        foreach ($propertyTypes as $type) {
            DB::table('properties')
                ->where('property_type', $type->slug)
                ->update(['property_type_id' => $type->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['property_type_id']);
            $table->dropColumn('property_type_id');
            // Reverting default value is complex, usually skipped or set back to null default
            $table->string('property_status')->nullable()->default(null)->change();
        });

        Schema::dropIfExists('property_types');
    }
};
