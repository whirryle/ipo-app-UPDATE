<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom untuk hierarki 3 level
            $table->foreignId('city_id')->nullable()->after('province_id')->constrained('cities');
            $table->foreignId('district_id')->nullable()->after('city_id')->constrained('districts');
            
            // Index untuk performa query
            $table->index(['city_id', 'district_id']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['district_id']);
            $table->dropColumn(['city_id', 'district_id']);
        });
    }
};
