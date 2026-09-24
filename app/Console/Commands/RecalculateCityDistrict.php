<?php

namespace App\Console\Commands;

use App\Services\IpoCalculator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateCityDistrict extends Command
{
    protected $signature = 'ipo:recalc-city-district {--year=}';
    protected $description = 'Recalculate IPO scores for all cities and districts';

    public function handle()
    {
        $year = $this->option('year') ?: IpoCalculator::latestYear();
        $this->info("Recalculating IPO scores for year $year...");

        // City-level
        $cities = DB::table('cities')->get();
        $this->info("Processing " . count($cities) . " cities...");
        foreach ($cities as $c) {
            $result = IpoCalculator::cityFull($c->id, $year);
            $status = ($result['_tanpaData'] ?? false) ? '(no data)' : "✓ {$result['display_score']}";
            $this->line("  {$c->name}: $status");
        }

        // District-level
        $districts = DB::table('districts')->get();
        $this->info("Processing " . count($districts) . " districts...");
        foreach ($districts as $d) {
            $result = IpoCalculator::districtFull($d->id, $year);
            $status = ($result['_tanpaData'] ?? false) ? '(no data)' : "✓ {$result['display_score']}";
            $this->line("  {$d->name}: $status");
        }

        $this->info("Done!");
    }
}
