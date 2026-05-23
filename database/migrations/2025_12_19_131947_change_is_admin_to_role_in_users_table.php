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
        Schema::table('users', function (Blueprint $table) {
            // Convert existing is_admin to role
            // First, add the role column
            $table->enum('role', ['admin', 'superadmin'])->nullable()->after('email');
        });

        // Migrate existing data: if is_admin is true, set role to 'superadmin', otherwise 'admin' or null
        DB::table('users')->where('is_admin', true)->update(['role' => 'superadmin']);
        DB::table('users')->where('is_admin', false)->update(['role' => null]);

        Schema::table('users', function (Blueprint $table) {
            // Drop the is_admin column
            $table->dropColumn('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back is_admin column
            $table->boolean('is_admin')->default(false)->after('email');
        });

        // Migrate data back: if role is 'admin' or 'superadmin', set is_admin to true
        DB::table('users')->whereIn('role', ['admin', 'superadmin'])->update(['is_admin' => true]);
        DB::table('users')->whereNull('role')->update(['is_admin' => false]);

        Schema::table('users', function (Blueprint $table) {
            // Drop the role column
            $table->dropColumn('role');
        });
    }
};
