<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AngketResponden extends Model
{
    protected $table = 'angket_responden';

    protected $fillable = [
        'operator_id',
        'district_id',
        'city_id',
        'province_id',
        'year',
        
        // A. Identitas
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'tinggi_badan',
        'berat_badan',
        'pendidikan',
        'pekerjaan',
        'pendapatan',
        
        // B. Literasi Fisik
        'literasi_frekuensi',
        'literasi_durasi',
        'literasi_intensitas',
        'literasi_kesenangan',
        'literasi_membaca',
        'literasi_menonton',
        'literasi_murah',
        
        // C. Partisipasi
        'partisipasi_minggu_lalu',
        'partisipasi_frekuensi',
        'partisipasi_durasi',
        'partisipasi_intensitas',
        'partisipasi_jenis',
        'partisipasi_tujuan',
        'partisipasi_tempat',
        
        // D. Perkembangan Personal
        'personal_tantangan',
        'personal_putus_asa',
        'personal_solusi',
        'personal_pertemuan',
        'personal_curiga',
        'personal_percaya',
        
        // E. Kesehatan
        'kesehatan_gangguan',
        'kesehatan_puas',
        'kesehatan_kesiapan',
        'kesehatan_yakin',
        'kesehatan_karakter',
        'kesehatan_tujuan',
        
        // F. Ekonomi
        'ekonomi_belanja',
        'ekonomi_budget',
        'ekonomi_barang_dibeli',
        'ekonomi_jasa_dibayar',
        
        // G. Kebugaran
        'kebugaran_level',
        'kebugaran_balikan',
        'kebugaran_vo2max',
        
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tinggi_badan' => 'integer',
        'berat_badan' => 'decimal:2',
        'literasi_kesenangan' => 'integer',
        'literasi_membaca' => 'integer',
        'literasi_menonton' => 'integer',
        'literasi_murah' => 'integer',
        'partisipasi_intensitas' => 'integer',
        'personal_tantangan' => 'integer',
        'personal_putus_asa' => 'integer',
        'personal_solusi' => 'integer',
        'personal_pertemuan' => 'integer',
        'personal_curiga' => 'integer',
        'personal_percaya' => 'integer',
        'kesehatan_gangguan' => 'integer',
        'kesehatan_puas' => 'integer',
        'kesehatan_kesiapan' => 'integer',
        'kesehatan_yakin' => 'integer',
        'kesehatan_karakter' => 'integer',
        'kesehatan_tujuan' => 'integer',
        'ekonomi_barang_dibeli' => 'array',
        'ekonomi_jasa_dibayar' => 'array',
        'year' => 'integer',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    
    // Helper: Check if max 30 responden per district per year
    public static function canAddResponden($districtId, $year): bool
    {
        $count = self::where('district_id', $districtId)
            ->where('year', $year)
            ->where('status', 'submitted')
            ->count();
        
        return $count < 30;
    }
    
    // Helper: Get count of responden for district in year
    public static function countResponden($districtId, $year): int
    {
        return self::where('district_id', $districtId)
            ->where('year', $year)
            ->where('status', 'submitted')
            ->count();
    }
}
