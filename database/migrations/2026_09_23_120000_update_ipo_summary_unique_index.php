<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Update unique index to support IPO per city and per district,
     * not just per province.
     */
    public function up(): void
    {
        // Drop old unique index (province_id, year)
        Schema::table('ipo_summary', function (Blueprint $table) {
            $table->dropUnique('ipo_summary_province_id_year_unique');
        });

        // Add new composite unique index: province_id + city_id + district_id + year
        // This allows:
        //   - Province-level IPO (city_id=NULL, district_id=NULL)
        //   - City-level IPO (city_id=set, district_id=NULL)
        //   - District-level IPO (city_id=set, district_id=set)
        Schema::table('ipo_summary', function (Blueprint $table) {
            $table->unique(['province_id', 'city_id', 'district_id', 'year'], 'ipo_summary_scope_year_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ipo_summary', function (Blueprint $table) {
            $table->dropUnique('ipo_summary_scope_year_unique');
            $table->unique(['province_id', 'year'], 'ipo_summary_province_id_year_unique');
        });
    }
};
