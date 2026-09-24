<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    protected $table = 'ipo_bobot';

    protected $fillable = [
        'year',
        'literasi_fisik',
        'partisipasi',
        'perkembangan_personal',
        'kesehatan',
        'ekonomi',
        'kebugaran',
        'user_id',
    ];

    protected $casts = [
        'year' => 'integer',
        'literasi_fisik' => 'decimal:2',
        'partisipasi' => 'decimal:2',
        'perkembangan_personal' => 'decimal:2',
        'kesehatan' => 'decimal:2',
        'ekonomi' => 'decimal:2',
        'kebugaran' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getBobot(int $year): array
    {
        $bobot = self::where('year', $year)->first();
        
        if (!$bobot) {
            // Return default bobot
            return [
                'literasi_fisik' => 7,
                'partisipasi' => 7,
                'perkembangan_personal' => 6,
                'kesehatan' => 6,
                'ekonomi' => 4,
                'kebugaran' => 3,
            ];
        }

        return [
            'literasi_fisik' => (float) $bobot->literasi_fisik,
            'partisipasi' => (float) $bobot->partisipasi,
            'perkembangan_personal' => (float) $bobot->perkembangan_personal,
            'kesehatan' => (float) $bobot->kesehatan,
            'ekonomi' => (float) $bobot->ekonomi,
            'kebugaran' => (float) $bobot->kebugaran,
        ];
    }
}
