<?php

namespace App\Http\Controllers;

use App\Services\IpoCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BandingController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) ($request->query('year') ?: IpoCalculator::latestYear());
        $u = $request->user();
        $def = $u->city_id ? [(int) $u->city_id] : [1, 2];
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $request->query('c', $def)))));
        $ids = array_slice($ids, 0, 4);
        $cities = DB::table('cities')->whereIn('id', $ids)->orderBy('name')->get();
        $dims = [];
        $labels = ['d1_sdm' => 'SDM', 'd2_ruang_terbuka' => 'Ruang', 'd3_literasi_fisik' => 'Literasi', 'd4_partisipasi' => 'Partisipasi', 'd5_kebugaran' => 'Bugar', 'd6_kesehatan' => 'Sehat', 'd7_perkembangan_personal' => 'Personal', 'd8_ekonomi' => 'Ekonomi', 'd9_performa' => 'Performa'];
        foreach ($cities as $c) {
            $r = IpoCalculator::cityFull($c->id, $year);
            $skor = [];
            foreach ($labels as $k => $label) $skor[$k] = round((float) ($r[$k] ?? 0) * 100, 1);
            $dims[] = ['id' => $c->id, 'nama' => $c->name, 'skor' => $skor, 'ipo' => round((float) $r['ipo_score'] * 100, 2)];
        }
        if ($request->expectsJson()) return response()->json(['year' => $year, 'data' => $dims]);
        if ($request->query('ekspor') === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('banding_pdf', ['year' => $year, 'dims' => $dims, 'labels' => $labels])->setPaper('a4', 'landscape');
            return $pdf->download("IPO-Banding-{$year}.pdf");
        }
        return view('banding', ['year' => $year, 'dims' => $dims, 'labels' => $labels, 'pilih' => $ids,
            'cities' => DB::table('cities')->where('province_id', 1)->orderBy('name')->get(),
            'years' => range($year, 2020)]);
    }
}