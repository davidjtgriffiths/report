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
        // Step 1: Temporarily allow null values
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('sent')->nullable()->change();
        });

        // Step 2: Update existing data
        DB::table('messages')->where('sent', true)->update(['sent' => DB::raw('CURRENT_TIMESTAMP')]);
        DB::table('messages')->where('sent', false)->update(['sent' => null]);

        // Step 3: Change column type to timestamp
        Schema::table('messages', function (Blueprint $table) {
            $table->timestamp('sent')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Change column back to boolean
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('sent')->default(false)->change();
        });

        // Step 2: Reset data if necessary
        DB::table('messages')->whereNotNull('sent')->update(['sent' => true]);
        DB::table('messages')->whereNull('sent')->update(['sent' => false]);

        // Step 3: Disallow null values again (if needed)
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('sent')->nullable(false)->change();
        });
    }
};