<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaltimUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Get Kaltim province
        $prov = DB::table('provinces')->where('name', 'Kalimantan Timur')->first();
        if (!$prov) {
            $this->command->error('❌ Provinsi Kalimantan Timur tidak ditemukan!');
            return;
        }

        // 1. Super Admin (Dispora Kaltim)
        DB::table('users')->insert([
            'username' => 'admin',
            'password_hash' => Hash::make('admin123'),
            'full_name' => 'Admin Dispora Kaltim',
            'role' => 'superadmin',
            'province_id' => $prov->id,
            'city_id' => null,
            'district_id' => null,
            'created_at' => now(),
        ]);

        // 2. Admin Kota/Kab (10 akun - 1 per kota/kabupaten)
        $cities = DB::table('cities')->where('province_id', $prov->id)->get();
        foreach ($cities as $city) {
            $slug = $this->slugify($city->name);
            DB::table('users')->insert([
                'username' => "admin_$slug",
                'password_hash' => Hash::make("{$slug}123"),
                'full_name' => "Admin {$city->name}",
                'role' => 'admin_city',
                'province_id' => $prov->id,
                'city_id' => $city->id,
                'district_id' => null,
                'created_at' => now(),
            ]);
        }

        // 3. Operator Kecamatan (105 akun - 1 operator per kecamatan)
        $districts = DB::table('districts')->get();
        foreach ($districts as $district) {
            $city = DB::table('cities')->where('id', $district->city_id)->first();
            if ($city) {
                $districtSlug = $this->slugify($district->name);
                $citySlug = $this->slugify($city->name);
                DB::table('users')->insert([
                    'username' => "operator_{$citySlug}_{$districtSlug}",
                    'password_hash' => Hash::make('operator123'),
                    'full_name' => "Operator {$district->name}",
                    'role' => 'operator',
                    'province_id' => $prov->id,
                    'city_id' => $city->id,
                    'district_id' => $district->id,
                    'created_at' => now(),
                ]);
            }
        }

        $this->command->info('✅ User 3 level berhasil di-seed:');
        $this->command->line('   • 1 Super Admin (admin / admin123)');
        $this->command->line('   • 10 Admin Kota/Kab (admin_samarinda / samarinda123, dll)');
        $this->command->line('   • 105 Operator Kecamatan (1 per kecamatan, operator_samarinda_loa_janan_ilir / operator123, dll)');
    }

    private function slugify(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '_', $text);
        $text = trim($text, '_');
        return $text;
    }
}
