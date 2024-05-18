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
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('user_role')->insert([
            ['name' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Approver Head Branch (Admin)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Head Branch Accounts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sub-Branch Sales', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stockist Head Branch', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stockist Sub-Branch', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stock Uploader', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Report', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
