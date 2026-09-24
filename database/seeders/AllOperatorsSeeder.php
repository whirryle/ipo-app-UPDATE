<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AllOperatorsSeeder extends Seeder
{
    /**
     * Generate 105 operator accounts (1 per kecamatan di Kaltim)
     */
    public function run(): void
    {
        // Hapus operator lama dulu
        DB::table('users')->where('role', 'operator')->delete();

        $districts = DB::table('districts as d')
            ->join('cities as c', 'c.id', '=', 'd.city_id')
            ->where('c.province_id', 1)
            ->select('d.id', 'd.name as district_name', 'c.id as city_id', 'c.name as city_name')
            ->orderBy('c.id')
            ->orderBy('d.id')
            ->get();

        $operators = [];
        foreach ($districts as $d) {
            // Generate username: operator_cityslug_districtslug
            $citySlug = $this->slug($d->city_name);
            $districtSlug = $this->slug($d->district_name);
            $username = "operator_{$citySlug}_{$districtSlug}";
            
            // Full name: Operator Kec. [District Name]
            $fullName = "Operator Kec. {$d->district_name}";

            $operators[] = [
                'username' => $username,
                'password_hash' => Hash::make('operator123'),
                'full_name' => $fullName,
                'role' => 'operator',
                'province_id' => 1,
                'city_id' => $d->city_id,
                'district_id' => $d->id,
                'created_at' => now(),
            ];
        }

        // Insert in chunks untuk performa
        foreach (array_chunk($operators, 50) as $chunk) {
            DB::table('users')->insert($chunk);
        }

        $this->command->info('✅ 105 operator kecamatan berhasil di-generate!');
    }

    /**
     * Convert name to slug (lowercase, replace spaces/special chars with underscore)
     */
    private function slug(string $name): string
    {
        $name = strtolower($name);
        // Remove "Kota ", "Kabupaten ", "Kec. " prefix
        $name = preg_replace('/^(kota|kabupaten|kec\.?)\s+/i', '', $name);
        // Replace spaces and special chars
        $name = preg_replace('/[^a-z0-9]+/', '_', $name);
        // Remove leading/trailing underscores
        return trim($name, '_');
    }
}
