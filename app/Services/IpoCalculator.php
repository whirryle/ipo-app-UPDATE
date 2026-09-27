<?php

namespace App\Services;

use App\Models\Bobot;
use Illuminate\Support\Facades\DB;

// Port 1:1 dari services/calculator.js — rumus identik agar skor sama.
class IpoCalculator
{
    // Default bobot untuk dimensi angket responden
    private const DEFAULT_BOBOT = [
        'literasi_fisik' => 7,
        'partisipasi' => 7,
        'perkembangan_personal' => 6,
        'kesehatan' => 6,
        'ekonomi' => 4,
        'kebugaran' => 3,
    ];

    // Baca bobot untuk tahun tertentu (dari DB atau default)
    private static function getBobot(int $year): array
    {
        $bobot = Bobot::where('year', $year)->first();
        
        if ($bobot) {
            return [
                'literasi_fisik' => (float) $bobot->literasi_fisik,
                'partisipasi' => (float) $bobot->partisipasi,
                'perkembangan_personal' => (float) $bobot->perkembangan_personal,
                'kesehatan' => (float) $bobot->kesehatan,
                'ekonomi' => (float) $bobot->ekonomi,
                'kebugaran' => (float) $bobot->kebugaran,
            ];
        }
        
        return self::DEFAULT_BOBOT;
    }
    public const CATEGORIES = [
        ['min' => 0, 'max' => 25, 'label' => 'Sangat Kurang'],
        ['min' => 26, 'max' => 50, 'label' => 'Kurang'],
        ['min' => 51, 'max' => 75, 'label' => 'Cukup'],
        ['min' => 76, 'max' => 100, 'label' => 'Baik'],
    ];

    public static function kategori(float $score): string
    {
        $display = $score * 100;
        foreach (self::CATEGORIES as $cat) {
            if ($display >= $cat['min'] && $display <= $cat['max']) {
                return $cat['label'];
            }
        }
        return 'Sangat Kurang';
    }

    public static function kategoriFromDisplay(?float $display): string
    {
        if ($display === null) return 'Belum Ada Data';
        if ($display >= 76) return 'Baik';
        if ($display >= 51) return 'Cukup';
        if ($display >= 26) return 'Kurang';
        return 'Sangat Kurang';
    }

    public static function kebugaranKategori(float $vo2max): string
    {
        if ($vo2max >= 51.2) return 'Unggul';
        if ($vo2max >= 44.3) return 'Baik Sekali';
        if ($vo2max >= 38.3) return 'Baik';
        if ($vo2max >= 32.0) return 'Sedang';
        if ($vo2max >= 26.8) return 'Kurang';
        return 'Kurang Sekali';
    }

    private static function respJoin(string $alias, string $yearCol): string
    {
        return "JOIN respondents r ON {$alias}.respondent_id = r.id "
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'JOIN cities c ON d.city_id = c.id ';
    }

    public static function provinceSDM(int $pid, int $year): float
    {
        $r = DB::selectOne(
            'SELECT AVG(s.indeks) v FROM sdm_olahraga s '
            . 'JOIN districts d ON s.district_id = d.id '
            . 'JOIN cities c ON d.city_id = c.id '
            . 'WHERE c.province_id = ? AND s.year = ?', [$pid, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function provinceRuangTerbuka(int $pid, int $year): float
    {
        $r = DB::selectOne(
            'SELECT AVG(r.indeks) v FROM ruang_terbuka r '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'JOIN cities c ON d.city_id = c.id '
            . 'WHERE c.province_id = ? AND r.year = ?', [$pid, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function provinceLiterasi(int $pid, int $year): float
    {
        // Try new angket_responden data first, fallback to old literasi_fisik table
        $literasi = self::provinceLiterasiFromAngket($pid, $year);
        if ($literasi > 0) return $literasi;
        
        $r = DB::selectOne(
            'SELECT AVG(l.indeks) v FROM literasi_fisik l ' . self::respJoin('l', 'l.year')
            . 'WHERE c.province_id = ? AND l.year = ?', [$pid, $year]);
        return (float) ($r->v ?? 0);
    }
    
    /**
     * Calculate Literasi Fisik from angket_responden (new model)
     */
    private static function provinceLiterasiFromAngket(int $pid, int $year): float
    {
        $districts = DB::select(
            'SELECT d.id FROM districts d JOIN cities c ON c.id = d.city_id WHERE c.province_id = ?',
            [$pid]
        );
        
        if (empty($districts)) return 0;
        
        $total = 0;
        $count = 0;
        
        foreach ($districts as $d) {
            $score = \App\Services\AngketRespondenScoreCalculator::literasiFisik($d->id, $year);
            if ($score > 0) {
                $total += $score;
                $count++;
            }
        }
        
        return $count > 0 ? $total / $count : 0;
    }

    public static function provincePartisipasi(int $pid, int $year): float
    {
        // Try new angket_responden data first, fallback to old partisipasi table
        $partisipasi = self::provincePartisipasiFromAngket($pid, $year);
        if ($partisipasi > 0) return $partisipasi;
        
        $r = DB::selectOne(
            'SELECT COUNT(CASE WHEN p.frekuensi >= 3 THEN 1 END) aktif, COUNT(*) total '
            . 'FROM partisipasi p ' . self::respJoin('p', 'p.year')
            . 'WHERE c.province_id = ? AND p.year = ?', [$pid, $year]);
        if (!$r || !$r->total) return 0;
        return $r->aktif / $r->total;
    }
    
    private static function provincePartisipasiFromAngket(int $pid, int $year): float
    {
        $districts = DB::select(
            'SELECT d.id FROM districts d JOIN cities c ON c.id = d.city_id WHERE c.province_id = ?',
            [$pid]
        );
        
        if (empty($districts)) return 0;
        
        $total = 0;
        $count = 0;
        
        foreach ($districts as $d) {
            $score = \App\Services\AngketRespondenScoreCalculator::partisipasi($d->id, $year);
            if ($score > 0) {
                $total += $score;
                $count++;
            }
        }
        
        return $count > 0 ? $total / $count : 0;
    }

    public static function provinceKebugaran(int $pid, int $year): float
    {
        // Try new angket_responden data first
        $kebugaran = self::provinceKebugaranFromAngket($pid, $year);
        if ($kebugaran > 0) return $kebugaran;
        
        $r = DB::selectOne(
            'SELECT AVG(k.indeks) v FROM kebugaran k ' . self::respJoin('k', 'k.year')
            . 'WHERE c.province_id = ? AND k.year = ?', [$pid, $year]);
        return (float) ($r->v ?? 0);
    }
    
    private static function provinceKebugaranFromAngket(int $pid, int $year): float
    {
        $districts = DB::select(
            'SELECT d.id FROM districts d JOIN cities c ON c.id = d.city_id WHERE c.province_id = ?',
            [$pid]
        );
        
        if (empty($districts)) return 0;
        
        $total = 0;
        $count = 0;
        
        foreach ($districts as $d) {
            $score = \App\Services\AngketRespondenScoreCalculator::kebugaran($d->id, $year);
            if ($score > 0) {
                $total += $score;
                $count++;
            }
        }
        
        return $count > 0 ? $total / $count : 0;
    }

    public static function provinceKesehatan(int $pid, int $year): float
    {
        // Try new angket_responden data first
        $kesehatan = self::provinceKesehatanFromAngket($pid, $year);
        if ($kesehatan > 0) return $kesehatan;
        
        $r = DB::selectOne(
            'SELECT AVG(k.indeks) v FROM kesehatan k ' . self::respJoin('k', 'k.year')
            . 'WHERE c.province_id = ? AND k.year = ?', [$pid, $year]);
        return (float) ($r->v ?? 0);
    }
    
    private static function provinceKesehatanFromAngket(int $pid, int $year): float
    {
        $districts = DB::select(
            'SELECT d.id FROM districts d JOIN cities c ON c.id = d.city_id WHERE c.province_id = ?',
            [$pid]
        );
        
        if (empty($districts)) return 0;
        
        $total = 0;
        $count = 0;
        
        foreach ($districts as $d) {
            $score = \App\Services\AngketRespondenScoreCalculator::kesehatan($d->id, $year);
            if ($score > 0) {
                $total += $score;
                $count++;
            }
        }
        
        return $count > 0 ? $total / $count : 0;
    }

    public static function provincePerkembangan(int $pid, int $year): float
    {
        // Try new angket_responden data first
        $personal = self::provincePerkembanganFromAngket($pid, $year);
        if ($personal > 0) return $personal;
        
        $r = DB::selectOne(
            'SELECT AVG(pp.indeks) v FROM perkembangan_personal pp ' . self::respJoin('pp', 'pp.year')
            . 'WHERE c.province_id = ? AND pp.year = ?', [$pid, $year]);
        return (float) ($r->v ?? 0);
    }
    
    private static function provincePerkembanganFromAngket(int $pid, int $year): float
    {
        $districts = DB::select(
            'SELECT d.id FROM districts d JOIN cities c ON c.id = d.city_id WHERE c.province_id = ?',
            [$pid]
        );
        
        if (empty($districts)) return 0;
        
        $total = 0;
        $count = 0;
        
        foreach ($districts as $d) {
            $score = \App\Services\AngketRespondenScoreCalculator::perkembanganPersonal($d->id, $year);
            if ($score > 0) {
                $total += $score;
                $count++;
            }
        }
        
        return $count > 0 ? $total / $count : 0;
    }

    public static function provinceEkonomi(int $pid, int $year): float
    {
        // Try new angket_responden data first
        $ekonomi = self::provinceEkonomiFromAngket($pid, $year);
        if ($ekonomi > 0) return $ekonomi;
        
        $r = DB::selectOne(
            'SELECT AVG(e.total_belanja) v FROM ekonomi e ' . self::respJoin('e', 'e.year')
            . 'WHERE c.province_id = ? AND e.year = ?', [$pid, $year]);
        return min(((float) ($r->v ?? 0)) / 5000000, 1);
    }
    
    private static function provinceEkonomiFromAngket(int $pid, int $year): float
    {
        $districts = DB::select(
            'SELECT d.id FROM districts d JOIN cities c ON c.id = d.city_id WHERE c.province_id = ?',
            [$pid]
        );
        
        if (empty($districts)) return 0;
        
        $total = 0;
        $count = 0;
        
        foreach ($districts as $d) {
            $score = \App\Services\AngketRespondenScoreCalculator::ekonomi($d->id, $year);
            if ($score > 0) {
                $total += $score;
                $count++;
            }
        }
        
        return $count > 0 ? $total / $count : 0;
    }

    public static function provincePerforma(int $pid, int $year): float
    {
        $r = DB::selectOne(
            'SELECT SUM(p.medali_emas) emas, SUM(p.medali_perak) perak, SUM(p.medali_perunggu) perunggu '
            . 'FROM performa p JOIN cities c ON p.city_id = c.id '
            . 'WHERE c.province_id = ? AND p.year = ?', [$pid, $year]);
        if (!$r) return 0;
        $na = ($r->emas ?? 0) * 5 + ($r->perak ?? 0) * 3 + ($r->perunggu ?? 0);
        return min($na / 200, 1);
    }

    // Hitung penuh IPO satu provinsi+tahun. Tanpa data sumber → tanpa upsert.
    public static function full(int $pid, int $year): array
    {
        $dims = [
            'd1_sdm' => self::provinceSDM($pid, $year),
            'd2_ruang_terbuka' => self::provinceRuangTerbuka($pid, $year),
            'd3_literasi_fisik' => self::provinceLiterasi($pid, $year),
            'd4_partisipasi' => self::provincePartisipasi($pid, $year),
            'd5_kebugaran' => self::provinceKebugaran($pid, $year),
            'd6_kesehatan' => self::provinceKesehatan($pid, $year),
            'd7_perkembangan_personal' => self::provincePerkembangan($pid, $year),
            'd8_ekonomi' => self::provinceEkonomi($pid, $year),
            'd9_performa' => self::provincePerforma($pid, $year),
        ];
        
        // Baca bobot dinamis dari database
        $bobot = self::getBobot($year);
        
        // Hitung skor dengan bobot (weighted average)
        // 6 dimensi angket responden dikali bobot, 3 dimensi lain dapat bobot default
        $totalBobotAngket = array_sum($bobot); // 36 untuk tahun 2026
        $bobotLain = (100 - $totalBobotAngket) / 3; // Distribusi sisa ke 3 dimensi lain
        
        $weightedSum = ($dims['d3_literasi_fisik'] * $bobot['literasi_fisik'])
                     + ($dims['d4_partisipasi'] * $bobot['partisipasi'])
                     + ($dims['d5_kebugaran'] * $bobot['kebugaran'])
                     + ($dims['d6_kesehatan'] * $bobot['kesehatan'])
                     + ($dims['d7_perkembangan_personal'] * $bobot['perkembangan_personal'])
                     + ($dims['d8_ekonomi'] * $bobot['ekonomi'])
                     + ($dims['d1_sdm'] * $bobotLain)
                     + ($dims['d2_ruang_terbuka'] * $bobotLain)
                     + ($dims['d9_performa'] * $bobotLain);
        $score = $weightedSum / 100; // Normalize ke 0-1
        
        $result = array_merge(
            ['province_id' => $pid, 'year' => $year],
            $dims,
            [
                'ipo_score' => $score,
                'display_score' => round($score * 100, 2),
                'kategori' => self::kategori($score),
            ]
        );

        $adaData = count(array_filter($dims, fn($d) => $d)) > 0;
        if (!$adaData) {
            $result['_tanpaData'] = true;
            return $result;
        }

        DB::table('ipo_summary')->upsert(
            array_merge($dims, [
                'province_id' => $pid, 'year' => $year,
                'city_id' => null, 'district_id' => null,
                'ipo_score' => $score, 'kategori' => self::kategori($score),
            ]),
            ['province_id', 'city_id', 'district_id', 'year']
        );
        return $result;
    }

    // ===== CITY-LEVEL CALCULATION =====
    
    public static function citySDM(int $cityId, int $year): float
    {
        $r = DB::selectOne(
            'SELECT AVG(s.indeks) v FROM sdm_olahraga s '
            . 'JOIN districts d ON s.district_id = d.id '
            . 'WHERE d.city_id = ? AND s.year = ?', [$cityId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function cityRuangTerbuka(int $cityId, int $year): float
    {
        $r = DB::selectOne(
            'SELECT AVG(r.indeks) v FROM ruang_terbuka r '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'WHERE d.city_id = ? AND r.year = ?', [$cityId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function cityLiterasi(int $cityId, int $year): float
    {
        // Try new angket_responden data first
        $literasi = \App\Services\AngketRespondenScoreCalculator::literasiFisikCity($cityId, $year);
        if ($literasi > 0) return $literasi;
        
        $r = DB::selectOne(
            'SELECT AVG(l.indeks) v FROM literasi_fisik l '
            . 'JOIN respondents r ON l.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'WHERE d.city_id = ? AND l.year = ?', [$cityId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function cityPartisipasi(int $cityId, int $year): float
    {
        // Try new angket_responden data first
        $partisipasi = \App\Services\AngketRespondenScoreCalculator::partisipasiCity($cityId, $year);
        if ($partisipasi > 0) return $partisipasi;
        
        $r = DB::selectOne(
            'SELECT COUNT(CASE WHEN p.frekuensi >= 3 THEN 1 END) aktif, COUNT(*) total '
            . 'FROM partisipasi p '
            . 'JOIN respondents r ON p.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'WHERE d.city_id = ? AND p.year = ?', [$cityId, $year]);
        if (!$r || !$r->total) return 0;
        return $r->aktif / $r->total;
    }

    public static function cityKebugaran(int $cityId, int $year): float
    {
        // Try new angket_responden data first
        $kebugaran = \App\Services\AngketRespondenScoreCalculator::kebugaranCity($cityId, $year);
        if ($kebugaran > 0) return $kebugaran;
        
        $r = DB::selectOne(
            'SELECT AVG(k.indeks) v FROM kebugaran k '
            . 'JOIN respondents r ON k.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'WHERE d.city_id = ? AND k.year = ?', [$cityId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function cityKesehatan(int $cityId, int $year): float
    {
        // Try new angket_responden data first
        $kesehatan = \App\Services\AngketRespondenScoreCalculator::kesehatanCity($cityId, $year);
        if ($kesehatan > 0) return $kesehatan;
        
        $r = DB::selectOne(
            'SELECT AVG(k.indeks) v FROM kesehatan k '
            . 'JOIN respondents r ON k.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'WHERE d.city_id = ? AND k.year = ?', [$cityId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function cityPerkembangan(int $cityId, int $year): float
    {
        // Try new angket_responden data first
        $personal = \App\Services\AngketRespondenScoreCalculator::perkembanganPersonalCity($cityId, $year);
        if ($personal > 0) return $personal;
        
        $r = DB::selectOne(
            'SELECT AVG(pp.indeks) v FROM perkembangan_personal pp '
            . 'JOIN respondents r ON pp.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'WHERE d.city_id = ? AND pp.year = ?', [$cityId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function cityEkonomi(int $cityId, int $year): float
    {
        // Try new angket_responden data first
        $ekonomi = \App\Services\AngketRespondenScoreCalculator::ekonomiCity($cityId, $year);
        if ($ekonomi > 0) return $ekonomi;
        
        $r = DB::selectOne(
            'SELECT AVG(e.total_belanja) v FROM ekonomi e '
            . 'JOIN respondents r ON e.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'JOIN districts d ON v.district_id = d.id '
            . 'WHERE d.city_id = ? AND e.year = ?', [$cityId, $year]);
        return min(((float) ($r->v ?? 0)) / 5000000, 1);
    }

    public static function cityPerforma(int $cityId, int $year): float
    {
        $r = DB::selectOne(
            'SELECT SUM(p.medali_emas) emas, SUM(p.medali_perak) perak, SUM(p.medali_perunggu) perunggu '
            . 'FROM performa p WHERE p.city_id = ? AND p.year = ?', [$cityId, $year]);
        if (!$r) return 0;
        $na = ($r->emas ?? 0) * 5 + ($r->perak ?? 0) * 3 + ($r->perunggu ?? 0);
        return min($na / 200, 1);
    }

    public static function cityFull(int $cityId, int $year): array
    {
        $dims = [
            'd1_sdm' => self::citySDM($cityId, $year),
            'd2_ruang_terbuka' => self::cityRuangTerbuka($cityId, $year),
            'd3_literasi_fisik' => self::cityLiterasi($cityId, $year),
            'd4_partisipasi' => self::cityPartisipasi($cityId, $year),
            'd5_kebugaran' => self::cityKebugaran($cityId, $year),
            'd6_kesehatan' => self::cityKesehatan($cityId, $year),
            'd7_perkembangan_personal' => self::cityPerkembangan($cityId, $year),
            'd8_ekonomi' => self::cityEkonomi($cityId, $year),
            'd9_performa' => self::cityPerforma($cityId, $year),
        ];
        
        // Baca bobot dinamis dari database
        $bobot = self::getBobot($year);
        
        // Hitung skor dengan bobot (weighted average)
        // 6 dimensi angket responden dikali bobot, 3 dimensi lain dapat bobot default
        $totalBobotAngket = array_sum($bobot); // 36 untuk tahun 2026
        $bobotLain = (100 - $totalBobotAngket) / 3; // Distribusi sisa ke 3 dimensi lain
        
        $weightedSum = ($dims['d3_literasi_fisik'] * $bobot['literasi_fisik'])
                     + ($dims['d4_partisipasi'] * $bobot['partisipasi'])
                     + ($dims['d5_kebugaran'] * $bobot['kebugaran'])
                     + ($dims['d6_kesehatan'] * $bobot['kesehatan'])
                     + ($dims['d7_perkembangan_personal'] * $bobot['perkembangan_personal'])
                     + ($dims['d8_ekonomi'] * $bobot['ekonomi'])
                     + ($dims['d1_sdm'] * $bobotLain)
                     + ($dims['d2_ruang_terbuka'] * $bobotLain)
                     + ($dims['d9_performa'] * $bobotLain);
        $score = $weightedSum / 100; // Normalize ke 0-1
        
        $result = array_merge(
            ['city_id' => $cityId, 'year' => $year],
            $dims,
            [
                'ipo_score' => $score,
                'display_score' => round($score * 100, 2),
                'kategori' => self::kategori($score),
            ]
        );

        $adaData = count(array_filter($dims, fn($d) => $d)) > 0;
        if (!$adaData) {
            $result['_tanpaData'] = true;
            return $result;
        }

        $city = DB::table('cities')->where('id', $cityId)->first();
        DB::table('ipo_summary')->upsert(
            array_merge($dims, [
                'province_id' => $city->province_id,
                'city_id' => $cityId,
                'district_id' => null,
                'year' => $year,
                'ipo_score' => $score,
                'kategori' => self::kategori($score),
            ]),
            ['province_id', 'city_id', 'district_id', 'year']
        );
        return $result;
    }

    // ===== DISTRICT-LEVEL CALCULATION =====
    
    public static function districtSDM(int $districtId, int $year): float
    {
        $r = DB::selectOne(
            'SELECT AVG(s.indeks) v FROM sdm_olahraga s '
            . 'WHERE s.district_id = ? AND s.year = ?', [$districtId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function districtRuangTerbuka(int $districtId, int $year): float
    {
        $r = DB::selectOne(
            'SELECT AVG(r.indeks) v FROM ruang_terbuka r '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'WHERE v.district_id = ? AND r.year = ?', [$districtId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function districtLiterasi(int $districtId, int $year): float
    {
        // Try new angket_responden data first
        $literasi = \App\Services\AngketRespondenScoreCalculator::literasiFisik($districtId, $year);
        if ($literasi > 0) return $literasi;
        
        $r = DB::selectOne(
            'SELECT AVG(l.indeks) v FROM literasi_fisik l '
            . 'JOIN respondents r ON l.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'WHERE v.district_id = ? AND l.year = ?', [$districtId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function districtPartisipasi(int $districtId, int $year): float
    {
        // Try new angket_responden data first
        $partisipasi = \App\Services\AngketRespondenScoreCalculator::partisipasi($districtId, $year);
        if ($partisipasi > 0) return $partisipasi;
        
        $r = DB::selectOne(
            'SELECT COUNT(CASE WHEN p.frekuensi >= 3 THEN 1 END) aktif, COUNT(*) total '
            . 'FROM partisipasi p '
            . 'JOIN respondents r ON p.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'WHERE v.district_id = ? AND p.year = ?', [$districtId, $year]);
        if (!$r || !$r->total) return 0;
        return $r->aktif / $r->total;
    }

    public static function districtKebugaran(int $districtId, int $year): float
    {
        // Try new angket_responden data first
        $kebugaran = \App\Services\AngketRespondenScoreCalculator::kebugaran($districtId, $year);
        if ($kebugaran > 0) return $kebugaran;
        
        $r = DB::selectOne(
            'SELECT AVG(k.indeks) v FROM kebugaran k '
            . 'JOIN respondents r ON k.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'WHERE v.district_id = ? AND k.year = ?', [$districtId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function districtKesehatan(int $districtId, int $year): float
    {
        // Try new angket_responden data first
        $kesehatan = \App\Services\AngketRespondenScoreCalculator::kesehatan($districtId, $year);
        if ($kesehatan > 0) return $kesehatan;
        
        $r = DB::selectOne(
            'SELECT AVG(k.indeks) v FROM kesehatan k '
            . 'JOIN respondents r ON k.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'WHERE v.district_id = ? AND k.year = ?', [$districtId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function districtPerkembangan(int $districtId, int $year): float
    {
        // Try new angket_responden data first
        $personal = \App\Services\AngketRespondenScoreCalculator::perkembanganPersonal($districtId, $year);
        if ($personal > 0) return $personal;
        
        $r = DB::selectOne(
            'SELECT AVG(pp.indeks) v FROM perkembangan_personal pp '
            . 'JOIN respondents r ON pp.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'WHERE v.district_id = ? AND pp.year = ?', [$districtId, $year]);
        return (float) ($r->v ?? 0);
    }

    public static function districtEkonomi(int $districtId, int $year): float
    {
        // Try new angket_responden data first
        $ekonomi = \App\Services\AngketRespondenScoreCalculator::ekonomi($districtId, $year);
        if ($ekonomi > 0) return $ekonomi;
        
        $r = DB::selectOne(
            'SELECT AVG(e.total_belanja) v FROM ekonomi e '
            . 'JOIN respondents r ON e.respondent_id = r.id '
            . 'JOIN villages v ON r.village_id = v.id '
            . 'WHERE v.district_id = ? AND e.year = ?', [$districtId, $year]);
        return min(((float) ($r->v ?? 0)) / 5000000, 1);
    }

    public static function districtPerforma(int $districtId, int $year): float
    {
        // Performa per district tidak ada di tabel performa (hanya city-level)
        // Return 0 untuk consistency
        return 0;
    }

    public static function districtFull(int $districtId, int $year): array
    {
        $dims = [
            'd1_sdm' => self::districtSDM($districtId, $year),
            'd2_ruang_terbuka' => self::districtRuangTerbuka($districtId, $year),
            'd3_literasi_fisik' => self::districtLiterasi($districtId, $year),
            'd4_partisipasi' => self::districtPartisipasi($districtId, $year),
            'd5_kebugaran' => self::districtKebugaran($districtId, $year),
            'd6_kesehatan' => self::districtKesehatan($districtId, $year),
            'd7_perkembangan_personal' => self::districtPerkembangan($districtId, $year),
            'd8_ekonomi' => self::districtEkonomi($districtId, $year),
            'd9_performa' => self::districtPerforma($districtId, $year),
        ];
        
        // Baca bobot dinamis dari database
        $bobot = self::getBobot($year);
        
        // Hitung skor dengan bobot (weighted average)
        // 6 dimensi angket responden dikali bobot, 3 dimensi lain dapat bobot default
        $totalBobotAngket = array_sum($bobot); // 36 untuk tahun 2026
        $bobotLain = (100 - $totalBobotAngket) / 3; // Distribusi sisa ke 3 dimensi lain
        
        $weightedSum = ($dims['d3_literasi_fisik'] * $bobot['literasi_fisik'])
                     + ($dims['d4_partisipasi'] * $bobot['partisipasi'])
                     + ($dims['d5_kebugaran'] * $bobot['kebugaran'])
                     + ($dims['d6_kesehatan'] * $bobot['kesehatan'])
                     + ($dims['d7_perkembangan_personal'] * $bobot['perkembangan_personal'])
                     + ($dims['d8_ekonomi'] * $bobot['ekonomi'])
                     + ($dims['d1_sdm'] * $bobotLain)
                     + ($dims['d2_ruang_terbuka'] * $bobotLain)
                     + ($dims['d9_performa'] * $bobotLain);
        $score = $weightedSum / 100; // Normalize ke 0-1
        
        $result = array_merge(
            ['district_id' => $districtId, 'year' => $year],
            $dims,
            [
                'ipo_score' => $score,
                'display_score' => round($score * 100, 2),
                'kategori' => self::kategori($score),
            ]
        );

        $adaData = count(array_filter($dims, fn($d) => $d)) > 0;
        if (!$adaData) {
            $result['_tanpaData'] = true;
            return $result;
        }

        $district = DB::table('districts')->where('id', $districtId)->first();
        $city = DB::table('cities')->where('id', $district->city_id)->first();
        DB::table('ipo_summary')->upsert(
            array_merge($dims, [
                'province_id' => $city->province_id,
                'city_id' => $district->city_id,
                'district_id' => $districtId,
                'year' => $year,
                'ipo_score' => $score,
                'kategori' => self::kategori($score),
            ]),
            ['province_id', 'city_id', 'district_id', 'year']
        );
        return $result;
    }

    // Tahun terbaru yang punya data SUMBER (abaikan ipo_summary).
    public static function latestYear(): int
    {
        $max = 0;
        foreach (['sdm_olahraga', 'ruang_terbuka', 'literasi_fisik', 'partisipasi', 'kebugaran', 'kesehatan', 'perkembangan_personal', 'ekonomi', 'performa', 'respondents'] as $t) {
            try {
                $m = DB::table($t)->max('year');
                if ($m > $max) $max = $m;
            } catch (\Throwable $e) { /* abaikan */
            }
        }
        return $max ?: (int) date('Y');
    }
}
