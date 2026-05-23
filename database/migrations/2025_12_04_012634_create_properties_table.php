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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('location_text');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('land_size', 10, 2)->nullable();
            $table->decimal('building_size', 10, 2)->nullable();
            $table->integer('year_of_build')->nullable();
            $table->integer('floor_level')->nullable();
            $table->string('view')->nullable();
            $table->string('style_design')->nullable();
            $table->text('surrounding')->nullable();
            $table->string('imb')->nullable();
            
            // Indoor
            $table->string('living_room_type')->nullable();
            $table->string('dining_room_type')->nullable();
            $table->string('kitchen_type')->nullable();
            $table->integer('bedroom')->nullable();
            $table->integer('bathroom')->nullable();
            $table->integer('ensuite_bathroom')->nullable();
            $table->string('extra_room')->nullable();
            $table->string('storage')->nullable();
            
            // Outdoor
            $table->boolean('swimming_pool')->default(false);
            $table->boolean('terrace')->default(false);
            $table->boolean('balcony')->default(false);
            $table->boolean('shower')->default(false);
            
            // Facilities
            $table->string('furniture')->nullable();
            $table->string('electricity_power')->nullable();
            $table->integer('ac_count')->nullable();
            $table->string('water_source')->nullable();
            $table->string('internet')->nullable();
            $table->string('parking_type')->nullable();
            $table->integer('parking_size')->nullable();
            
            // Monthly Cost
            $table->text('monthly_cost_included')->nullable();
            $table->boolean('banjar_security')->default(false);
            $table->boolean('cleaning_service')->default(false);
            $table->boolean('pool_maintenance')->default(false);
            $table->boolean('garden_maintenance')->default(false);
            $table->boolean('bin_collection')->default(false);
            $table->boolean('electricity_included')->default(false);
            $table->boolean('internet_included')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
