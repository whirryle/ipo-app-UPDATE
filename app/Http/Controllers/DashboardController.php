<?php

namespace App\Http\Controllers;

use App\Services\IpoCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $u = $request->user();
        $year = (int) ($request->query('year') ?: IpoCalculator::latestYear());
        
        // **DUAL DASHBOARD berdasarkan role**
        if ($u->isSuperAdmin()) {
            return $this->dashboardProvinsi($request, $u, $year);
        } elseif ($u->isAdminCity()) {
            return $this->dashboardKota($request, $u, $year);
        } else {
            return $this->dashboardKecamatan($request, $u, $year);
        }
    }

    // **Dashboard Provinsi — Super Admin (Dispora Kaltim)**
    private function dashboardProvinsi(Request $request, $u, int $year)
    {
        $pid = $u->province_id ?: (int) ($request->query('province_id') ?: 1);
        $summary = $this->getSummary($pid, $year);
        $province = DB::table('provinces')->where('id', $pid)->first();
        $dimensions = $this->getDimensions($summary);
        $counts = $this->scopedCounts($pid, $year);
        $trend = DB::table('ipo_summary')->select('year', 'ipo_score', 'kategori')
            ->where('province_id', $pid)->whereBetween('year', [$year - 4, $year])->orderBy('year')->get();
        
        // Ranking per kab/kota di Kaltim
        $cities = DB::table('cities')->where('province_id', $pid)->orderBy('name')->get();
        $cityScores = [];
        foreach ($cities as $c) {
            $result = IpoCalculator::cityFull($c->id, $year);
            if (!($result['_tanpaData'] ?? false)) {
                $cityScores[] = (object) [
                    'city_id' => $c->id,
                    'city_name' => $c->name,
                    'ipo_score' => $result['ipo_score'] ?? 0,
                    'display_score' => $result['display_score'] ?? 0,
                    'kategori' => $result['kategori'] ?? 'Belum Ada Data',
                ];
            }
        }
        usort($cityScores, fn($a, $b) => $b->ipo_score <=> $a->ipo_score);
        $cityRanking = collect(array_map(
            fn($c, $i) => (object) array_merge((array) $c, ['rank' => $i + 1]),
            $cityScores, array_keys($cityScores)
        ));

        return view('dashboard', [
            'year' => $year, 'pid' => $pid,
            'provinceName' => $province->name ?? 'Kalimantan Timur',
            'score' => $summary ? round((float) $summary->ipo_score * 100, 2) : 0,
            'kategori' => $summary->kategori ?? 'Belum Ada Data',
            'dimensions' => $dimensions,
            'totalRecords' => array_sum($counts), 'counts' => $counts,
            'trend' => $trend,
            'cityRanking' => $cityRanking,
            'years' => $this->yearOptions(),
            'provinces' => [],
            'roleLabel' => 'Super Admin — Dispora Kaltim',
            'nasional' => null,
        ]);
    }

    // **Dashboard Kota — Admin Kota/Kab**
    private function dashboardKota(Request $request, $u, int $year)
    {
        $pid = $u->province_id ?? 1; // Default Kaltim
        $cityId = $u->city_id ?? 1; // Default city pertama
        $summary = $this->getSummary($pid, $year);
        $province = DB::table('provinces')->where('id', $pid)->first();
        $city = DB::table('cities')->where('id', $cityId)->first();
        $dimensions = $this->getDimensions($summary);
        $counts = $this->scopedCounts($pid, $year, $cityId, null);
        $trend = DB::table('ipo_summary')->select('year', 'ipo_score', 'kategori')
            ->where('province_id', $pid)->whereBetween('year', [$year - 4, $year])->orderBy('year')->get();

        // Responden count per kecamatan di kota ini
        $districtRespondents = DB::table('respondents as r')
            ->join('villages as v', 'v.id', '=', 'r.village_id')
            ->join('districts as d', 'd.id', '=', 'v.district_id')
            ->select('d.name as district_name', DB::raw('COUNT(*) as count'))
            ->where('d.city_id', $cityId)
            ->where('r.year', $year)
            ->groupBy('d.id', 'd.name')
            ->orderBy('d.name')
            ->get();

        return view('dashboard', [
            'year' => $year, 'pid' => $pid,
            'provinceName' => $province->name ?? 'Kalimantan Timur',
            'cityName' => $city->name ?? '',
            'score' => $summary ? round((float) $summary->ipo_score * 100, 2) : 0,
            'kategori' => $summary->kategori ?? 'Belum Ada Data',
            'dimensions' => $dimensions,
            'totalRecords' => array_sum($counts), 'counts' => $counts,
            'trend' => $trend,
            'districtRespondents' => $districtRespondents,
            'respondentLimit' => 30,
            'years' => $this->yearOptions(),
            'provinces' => [],
            'roleLabel' => 'Admin ' . ($city->name ?? ''),
            'nasional' => null,
            'cityRanking' => null,
        ]);
    }

    // **Dashboard Kecamatan — Operator**
    private function dashboardKecamatan(Request $request, $u, int $year)
    {
        $pid = $u->province_id ?? 1; // Default Kaltim
        $cityId = $u->city_id ?? 1; // Default city pertama
        $districtId = $u->district_id ?? 1; // Default district pertama
        $summary = $this->getSummary($pid, $year);
        $province = DB::table('provinces')->where('id', $pid)->first();
        $city = DB::table('cities')->where('id', $cityId)->first();
        $district = DB::table('districts')->where('id', $districtId)->first();
        $dimensions = $this->getDimensions($summary);
        $counts = $this->scopedCounts($pid, $year, $cityId, $districtId);
        $trend = DB::table('ipo_summary')->select('year', 'ipo_score', 'kategori')
            ->where('province_id', $pid)->whereBetween('year', [$year - 4, $year])->orderBy('year')->get();

        // Counter responden di kecamatan ini
        $respondentCount = DB::table('respondents as r')
            ->join('villages as v', 'v.id', '=', 'r.village_id')
            ->where('v.district_id', $districtId)
            ->where('r.year', $year)
            ->count();
        
        // District-level IPO score
        $districtResult = IpoCalculator::districtFull($districtId, $year);
        $districtScore = ($districtResult['_tanpaData'] ?? false) ? 0 : ($districtResult['display_score'] ?? 0);
        $districtKategori = ($districtResult['_tanpaData'] ?? false) ? 'Belum Ada Data' : ($districtResult['kategori'] ?? 'Belum Ada Data');

        return view('dashboard', [
            'year' => $year, 'pid' => $pid,
            'provinceName' => $province->name ?? 'Kalimantan Timur',
            'cityName' => $city->name ?? '',
            'districtName' => $district->name ?? '',
            'score' => $districtScore,
            'kategori' => $districtKategori,
            'dimensions' => $dimensions,
            'totalRecords' => array_sum($counts), 'counts' => $counts,
            'trend' => $trend,
            'respondentCount' => $respondentCount,
            'respondentLimit' => 30,
            'years' => $this->yearOptions(),
            'provinces' => [],
            'roleLabel' => 'Operator ' . ($district->name ?? ''),
            'nasional' => null,
            'cityRanking' => null,
            'districtRespondents' => null,
        ]);
    }

    private function getSummary(int $pid, int $year)
    {
        $summary = DB::table('ipo_summary')
            ->where('province_id', $pid)
            ->whereNull('city_id')
            ->whereNull('district_id')
            ->where('year', $year)->first();
        if (!$summary) {
            IpoCalculator::full($pid, $year);
            $summary = DB::table('ipo_summary')
                ->where('province_id', $pid)
                ->whereNull('city_id')
                ->whereNull('district_id')
                ->where('year', $year)->first();
        }
        return $summary;
    }

    private function getDimensions($summary): array
    {
        $meta = [
            ['key' => 'd1_sdm', 'label' => 'SDM Olahraga'],
            ['key' => 'd2_ruang_terbuka', 'label' => 'Ruang Terbuka'],
            ['key' => 'd3_literasi_fisik', 'label' => 'Literasi Fisik'],
            ['key' => 'd4_partisipasi', 'label' => 'Partisipasi'],
            ['key' => 'd5_kebugaran', 'label' => 'Kebugaran Jasmani'],
            ['key' => 'd6_kesehatan', 'label' => 'Kesehatan'],
            ['key' => 'd7_perkembangan_personal', 'label' => 'Perkembangan Personal'],
            ['key' => 'd8_ekonomi', 'label' => 'Ekonomi'],
            ['key' => 'd9_performa', 'label' => 'Performa'],
        ];
        $dimensions = [];
        foreach ($meta as $m) {
            $v = $summary ? (float) ($summary->{$m['key']} ?? 0) : 0;
            $dimensions[] = ['key' => $m['key'], 'label' => $m['label'], 'value' => $v, 'display' => (int) round($v * 100)];
        }
        return $dimensions;
    }

    private function scopedCounts(int $pid, int $y, ?int $cityId = null, ?int $districtId = null): array
    {
        $c = function (string $table, string $join, $params) use ($y) {
            $q = DB::table("{$table} as x")->whereRaw($join, $params);
            return $q->count();
        };
        
        // **SDM Olahraga** (district_id)
        $params_sdm = [$pid, $y];
        $jSdm = 'EXISTS (SELECT 1 FROM districts d JOIN cities c ON c.id = d.city_id WHERE d.id = x.district_id AND c.province_id = ? AND x.year = ?';
        if ($cityId) {
            $jSdm .= ' AND c.id = ?';
            $params_sdm[] = $cityId;
        }
        if ($districtId) {
            $jSdm .= ' AND d.id = ?';
            $params_sdm[] = $districtId;
        }
        $jSdm .= ')';
        
        // **Ruang Terbuka** (village_id)
        $params_ruang = [$pid, $y];
        $jRuang = 'EXISTS (SELECT 1 FROM villages v JOIN districts d ON d.id = v.district_id JOIN cities c ON c.id = d.city_id WHERE v.id = x.village_id AND c.province_id = ? AND x.year = ?';
        if ($cityId) {
            $jRuang .= ' AND c.id = ?';
            $params_ruang[] = $cityId;
        }
        if ($districtId) {
            $jRuang .= ' AND d.id = ?';
            $params_ruang[] = $districtId;
        }
        $jRuang .= ')';
        
        // **Responden-based dimensions** (respondent_id)
        $params_resp = [$pid, $y];
        $jResp = 'EXISTS (SELECT 1 FROM respondents re JOIN villages v ON v.id = re.village_id JOIN districts d ON d.id = v.district_id JOIN cities c ON c.id = d.city_id WHERE re.id = x.respondent_id AND c.province_id = ? AND x.year = ?';
        if ($cityId) {
            $jResp .= ' AND c.id = ?';
            $params_resp[] = $cityId;
        }
        if ($districtId) {
            $jResp .= ' AND d.id = ?';
            $params_resp[] = $districtId;
        }
        $jResp .= ')';
        
        // **Performa** (city_id)
        $params_perf = [$pid, $y];
        $jPerf = 'EXISTS (SELECT 1 FROM cities c WHERE c.id = x.city_id AND c.province_id = ? AND x.year = ?';
        if ($cityId) {
            $jPerf .= ' AND c.id = ?';
            $params_perf[] = $cityId;
        }
        $jPerf .= ')';
        
        return [
            'sdm' => $c('sdm_olahraga', $jSdm, $params_sdm),
            'ruang' => $c('ruang_terbuka', $jRuang, $params_ruang),
            'literasi' => $c('literasi_fisik', $jResp, $params_resp),
            'partisipasi' => $c('partisipasi', $jResp, $params_resp),
            'kebugaran' => $c('kebugaran', $jResp, $params_resp),
            'kesehatan' => $c('kesehatan', $jResp, $params_resp),
            'perkembangan' => $c('perkembangan_personal', $jResp, $params_resp),
            'ekonomi' => $c('ekonomi', $jResp, $params_resp),
            'performa' => $c('performa', $jPerf, $params_perf),
        ];
    }

    private function yearOptions(): array
    {
        $tables = ['sdm_olahraga', 'ruang_terbuka', 'literasi_fisik', 'partisipasi', 'kebugaran', 'kesehatan', 'perkembangan_personal', 'ekonomi', 'performa', 'respondents'];
        $set = [];
        foreach ($tables as $t) {
            foreach (DB::table($t)->distinct()->pluck('year') as $y) $set[$y] = true;
        }
        $years = array_keys($set);
        rsort($years);
        return $years ?: [IpoCalculator::latestYear()];
    }
}
