<?php

namespace App\Services;

use App\Models\AngketResponden;
use Illuminate\Support\Facades\DB;

/**
 * Calculate IPO dimension scores from Angket Responden data.
 * Handles 6 dimensions: Literasi, Partisipasi, Personal, Kesehatan, Ekonomi, Kebugaran
 */
class AngketRespondenScoreCalculator
{
    /**
     * Calculate Literasi Fisik score (B dimension)
     * Average dari 7 pertanyaan (frekuensi, durasi, intensitas, kesenangan, membaca, menonton, murah)
     * Scale: normalize ke 0-1
     */
    public static function literasiFisik(int $districtId, int $year): float
    {
        $data = DB::selectOne(
            'SELECT AVG((literasi_frekuensi + literasi_durasi/60 + ' .
            'CASE WHEN literasi_intensitas = "berat" THEN 4 ' .
            'WHEN literasi_intensitas = "cukup_berat" THEN 3 ' .
            'WHEN literasi_intensitas = "sedang" THEN 2 ' .
            'ELSE 1 END + literasi_kesenangan + literasi_membaca + literasi_menonton + literasi_murah) / 7.0 / 5.0) as score ' .
            'FROM angket_responden WHERE district_id = ? AND year = ? AND status = "submitted"',
            [$districtId, $year]
        );
        
        return min(max((float) ($data->score ?? 0), 0), 1);
    }

    /**
     * Calculate Partisipasi score (C dimension)
     * Ratio: count yang jawab "ya" / total responden
     */
    public static function partisipasi(int $districtId, int $year): float
    {
        $result = DB::selectOne(
            'SELECT ' .
            'COUNT(CASE WHEN partisipasi_minggu_lalu = "ya" THEN 1 END) as aktif, ' .
            'COUNT(*) as total ' .
            'FROM angket_responden WHERE district_id = ? AND year = ? AND status = "submitted"',
            [$districtId, $year]
        );
        
        if (!$result || !$result->total) return 0;
        return $result->aktif / $result->total;
    }

    /**
     * Calculate Perkembangan Personal score (D dimension)
     * Average dari 6 pertanyaan (scale 1-5)
     */
    public static function perkembanganPersonal(int $districtId, int $year): float
    {
        $data = DB::selectOne(
            'SELECT AVG((personal_tantangan + personal_putus_asa + personal_solusi + ' .
            'personal_pertemuan + personal_curiga + personal_percaya) / 6.0 / 5.0) as score ' .
            'FROM angket_responden WHERE district_id = ? AND year = ? AND status = "submitted"',
            [$districtId, $year]
        );
        
        return min(max((float) ($data->score ?? 0), 0), 1);
    }

    /**
     * Calculate Kesehatan score (E dimension)
     * Average dari 6 pertanyaan (scale 1-5)
     */
    public static function kesehatan(int $districtId, int $year): float
    {
        $data = DB::selectOne(
            'SELECT AVG((kesehatan_gangguan + kesehatan_puas + kesehatan_kesiapan + ' .
            'kesehatan_yakin + kesehatan_karakter + kesehatan_tujuan) / 6.0 / 5.0) as score ' .
            'FROM angket_responden WHERE district_id = ? AND year = ? AND status = "submitted"',
            [$districtId, $year]
        );
        
        return min(max((float) ($data->score ?? 0), 0), 1);
    }

    /**
     * Calculate Ekonomi score (F dimension)
     * Aggregate: count "ya" / total (normalized ke 0-1)
     */
    public static function ekonomi(int $districtId, int $year): float
    {
        $result = DB::selectOne(
            'SELECT ' .
            'COUNT(CASE WHEN ekonomi_belanja = "ya" THEN 1 END) as belanja_ya, ' .
            'COUNT(*) as total ' .
            'FROM angket_responden WHERE district_id = ? AND year = ? AND status = "submitted"',
            [$districtId, $year]
        );
        
        if (!$result || !$result->total) return 0;
        return $result->belanja_ya / $result->total;
    }

    /**
     * Calculate Kebugaran score (G dimension)
     * Parse kebugaran_level, kebugaran_balikan, kebugaran_vo2max
     * Average mereka (normalized 0-1)
     */
    public static function kebugaran(int $districtId, int $year): float
    {
        $data = DB::selectOne(
            'SELECT COUNT(*) as total ' .
            'FROM angket_responden WHERE district_id = ? AND year = ? AND status = "submitted"',
            [$districtId, $year]
        );
        
        if (!$data || !$data->total) return 0;
        
        // Simple approach: count yang punya kebugaran_level filled / total
        $filled = DB::selectOne(
            'SELECT COUNT(*) as count ' .
            'FROM angket_responden WHERE district_id = ? AND year = ? AND status = "submitted" ' .
            'AND kebugaran_level IS NOT NULL AND kebugaran_level != ""',
            [$districtId, $year]
        );
        
        return ($filled->count ?? 0) / $data->total;
    }

    /**
     * Get all 6 dimension scores at once
     */
    public static function allDimensions(int $districtId, int $year): array
    {
        return [
            'd3_literasi_fisik' => self::literasiFisik($districtId, $year),
            'd4_partisipasi' => self::partisipasi($districtId, $year),
            'd7_perkembangan_personal' => self::perkembanganPersonal($districtId, $year),
            'd6_kesehatan' => self::kesehatan($districtId, $year),
            'd8_ekonomi' => self::ekonomi($districtId, $year),
            'd5_kebugaran' => self::kebugaran($districtId, $year),
        ];
    }

    /**
     * For city/province level: aggregate dari semua districts
     */
    public static function literasiFisikCity(int $cityId, int $year): float
    {
        $districts = DB::table('districts')->where('city_id', $cityId)->pluck('id');
        if ($districts->isEmpty()) return 0;
        
        $scores = $districts->map(fn($did) => self::literasiFisik($did, $year));
        return $scores->average();
    }

    public static function partisipasiCity(int $cityId, int $year): float
    {
        $districts = DB::table('districts')->where('city_id', $cityId)->pluck('id');
        if ($districts->isEmpty()) return 0;
        
        $scores = $districts->map(fn($did) => self::partisipasi($did, $year));
        return $scores->average();
    }

    public static function perkembanganPersonalCity(int $cityId, int $year): float
    {
        $districts = DB::table('districts')->where('city_id', $cityId)->pluck('id');
        if ($districts->isEmpty()) return 0;
        
        $scores = $districts->map(fn($did) => self::perkembanganPersonal($did, $year));
        return $scores->average();
    }

    public static function kesehatanCity(int $cityId, int $year): float
    {
        $districts = DB::table('districts')->where('city_id', $cityId)->pluck('id');
        if ($districts->isEmpty()) return 0;
        
        $scores = $districts->map(fn($did) => self::kesehatan($did, $year));
        return $scores->average();
    }

    public static function ekonomiCity(int $cityId, int $year): float
    {
        $districts = DB::table('districts')->where('city_id', $cityId)->pluck('id');
        if ($districts->isEmpty()) return 0;
        
        $scores = $districts->map(fn($did) => self::ekonomi($did, $year));
        return $scores->average();
    }

    public static function kebugaranCity(int $cityId, int $year): float
    {
        $districts = DB::table('districts')->where('city_id', $cityId)->pluck('id');
        if ($districts->isEmpty()) return 0;
        
        $scores = $districts->map(fn($did) => self::kebugaran($did, $year));
        return $scores->average();
    }

    /**
     * For province level: aggregate dari semua cities
     */
    public static function literasiFisikProvince(int $provinceId, int $year): float
    {
        $cities = DB::table('cities')->where('province_id', $provinceId)->pluck('id');
        if ($cities->isEmpty()) return 0;
        
        $scores = $cities->map(fn($cid) => self::literasiFisikCity($cid, $year));
        return $scores->average();
    }

    public static function partisipasiProvince(int $provinceId, int $year): float
    {
        $cities = DB::table('cities')->where('province_id', $provinceId)->pluck('id');
        if ($cities->isEmpty()) return 0;
        
        $scores = $cities->map(fn($cid) => self::partisipasiCity($cid, $year));
        return $scores->average();
    }

    public static function perkembanganPersonalProvince(int $provinceId, int $year): float
    {
        $cities = DB::table('cities')->where('province_id', $provinceId)->pluck('id');
        if ($cities->isEmpty()) return 0;
        
        $scores = $cities->map(fn($cid) => self::perkembanganPersonalCity($cid, $year));
        return $scores->average();
    }

    public static function kesehatanProvince(int $provinceId, int $year): float
    {
        $cities = DB::table('cities')->where('province_id', $provinceId)->pluck('id');
        if ($cities->isEmpty()) return 0;
        
        $scores = $cities->map(fn($cid) => self::kesehatanCity($cid, $year));
        return $scores->average();
    }

    public static function ekonomiProvince(int $provinceId, int $year): float
    {
        $cities = DB::table('cities')->where('province_id', $provinceId)->pluck('id');
        if ($cities->isEmpty()) return 0;
        
        $scores = $cities->map(fn($cid) => self::ekonomiCity($cid, $year));
        return $scores->average();
    }

    public static function kebugaranProvince(int $provinceId, int $year): float
    {
        $cities = DB::table('cities')->where('province_id', $provinceId)->pluck('id');
        if ($cities->isEmpty()) return 0;
        
        $scores = $cities->map(fn($cid) => self::kebugaranCity($cid, $year));
        return $scores->average();
    }
}
