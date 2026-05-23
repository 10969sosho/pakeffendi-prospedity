<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('so_number')->unique();
            $table->string('customer_full_name');
            $table->string('company_name');
            $table->string('whatsapp_number');
            $table->string('email');
            $table->string('pic_number')->nullable();

            $table->foreignId('service_package_id')->constrained('service_packages')->cascadeOnDelete();

            $table->string('package_name');
            $table->decimal('normal_price', 15, 2);
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->decimal('final_price', 15, 2);

            $table->string('status')->default('NEW');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
