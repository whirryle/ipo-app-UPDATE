<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillagesSeeder extends Seeder
{
    /**
     * Generate dummy villages (3-5 per kecamatan) untuk demo
     * Nanti diganti dengan data real dari BPS/Kemendes
     */
    public function run(): void
    {
        // Hapus villages lama dulu
        DB::table('villages')->delete();

        $villages = [];
        $id = 1;

        // Template desa per kecamatan (3-5 desa random)
        $templates = [
            1 => ['Desa A', 'Desa B', 'Desa C', 'Desa D'],
            2 => ['Kelurahan 1', 'Kelurahan 2', 'Kelurahan 3'],
            3 => ['Desa Maju', 'Desa Sejahtera', 'Desa Jaya', 'Desa Lestari'],
            4 => ['Desa Harapan', 'Desa Sentosa', 'Desa Makmur'],
            5 => ['Kelurahan Utama', 'Kelurahan Barat', 'Kelurahan Timur', 'Kelurahan Selatan'],
        ];

        // Ambil semua kecamatan
        $districts = DB::table('districts')->orderBy('id')->get();

        foreach ($districts as $d) {
            // Random 3-5 desa per kecamatan
            $count = rand(3, 5);
            $template = $templates[($d->id % 5) + 1] ?? ['Desa ' . chr(65 + ($d->id % 26))];

            for ($i = 0; $i < $count; $i++) {
                $villageName = ($template[$i] ?? 'Desa ' . ($i + 1)) . ' — ' . $d->name;
                
                $villages[] = [
                    'id' => $id++,
                    'district_id' => $d->id,
                    'name' => $villageName,
                ];
            }
        }

        // Insert in chunks
        foreach (array_chunk($villages, 100) as $chunk) {
            DB::table('villages')->insert($chunk);
        }

        $this->command->info('✅ ' . count($villages) . ' dummy villages seeded!');
        $this->command->info('📝 CATATAN: Ini dummy data untuk demo. Ganti dengan data real dari BPS/Kemendes Kaltim nanti.');
    }
}
