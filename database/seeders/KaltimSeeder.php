<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaltimSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hapus semua data provinsi lama
        DB::table('ipo_summary')->truncate();
        DB::table('performa')->truncate();
        DB::table('partisipasi')->truncate();
        DB::table('ekonomi')->truncate();
        DB::table('perkembangan_personal')->truncate();
        DB::table('kesehatan')->truncate();
        DB::table('kebugaran')->truncate();
        DB::table('literasi_fisik')->truncate();
        DB::table('ruang_terbuka')->truncate();
        DB::table('sdm_olahraga')->truncate();
        DB::table('respondents')->truncate();
        DB::table('users')->truncate();
        DB::table('villages')->truncate();
        DB::table('districts')->truncate();
        DB::table('cities')->truncate();
        DB::table('provinces')->truncate();

        // 2. Insert Provinsi Kalimantan Timur
        $provId = DB::table('provinces')->insertGetId(['name' => 'Kalimantan Timur']);

        // 3. Insert 10 Kabupaten/Kota
        $cities = [
            ['name' => 'Kota Samarinda', 'kecamatan' => [
                'Loa Janan Ilir', 'Palaran', 'Samarinda Ilir', 'Samarinda Kota',
                'Samarinda Seberang', 'Samarinda Ulu', 'Samarinda Utara',
                'Sambutan', 'Sungai Kunjang', 'Sungai Pinang'
            ]],
            ['name' => 'Kota Balikpapan', 'kecamatan' => [
                'Balikpapan Barat', 'Balikpapan Kota', 'Balikpapan Selatan',
                'Balikpapan Tengah', 'Balikpapan Timur', 'Balikpapan Utara'
            ]],
            ['name' => 'Kota Bontang', 'kecamatan' => [
                'Bontang Barat', 'Bontang Selatan', 'Bontang Utara'
            ]],
            ['name' => 'Kabupaten Kutai Kartanegara', 'kecamatan' => [
                'Anggana', 'Samboja', 'Samboja Barat', 'Muara Jawa', 'Sangasanga',
                'Loa Janan', 'Loa Kulu', 'Muara Muntai', 'Muara Wis', 'Kota Bangun',
                'Kota Bangun Darat', 'Tenggarong', 'Sebulu', 'Tenggarong Seberang',
                'Muara Kaman', 'Kenohan', 'Kembang Janggut', 'Tabang',
                'Marangkayu', 'Muara Badak'
            ]],
            ['name' => 'Kabupaten Kutai Timur', 'kecamatan' => [
                'Sangatta Utara', 'Sangatta Selatan', 'Teluk Pandan', 'Rantau Pulung',
                'Bengalon', 'Kaliorang', 'Kaubun', 'Karangan', 'Sandaran',
                'Sangkulirang', 'Muara Wahau', 'Telen', 'Kongbeng',
                'Muara Ancalong', 'Muara Bengkal', 'Long Mesangat', 'Busang', 'Batu Ampar'
            ]],
            ['name' => 'Kabupaten Kutai Barat', 'kecamatan' => [
                'Barong Tongkok', 'Melak', 'Sekolaq Darat', 'Linggang Bigung',
                'Bongan', 'Jempang', 'Muara Pahu', 'Penyinggahan', 'Muara Lawa',
                'Damai', 'Nyuatan', 'Bentian Besar', 'Siluq Ngurai', 'Tering',
                'Long Iram', 'Mook Manaar Bulatn'
            ]],
            ['name' => 'Kabupaten Paser', 'kecamatan' => [
                'Tanah Grogot', 'Paser Belengkong', 'Kuaro', 'Batu Sopang',
                'Muara Samu', 'Muara Komam', 'Long Ikis', 'Long Kali',
                'Batu Engau', 'Tanjung Harapan'
            ]],
            ['name' => 'Kabupaten Penajam Paser Utara', 'kecamatan' => [
                'Penajam', 'Waru', 'Babulu', 'Sepaku'
            ]],
            ['name' => 'Kabupaten Berau', 'kecamatan' => [
                'Tanjung Redeb', 'Sambaliung', 'Teluk Bayur', 'Gunung Tabur',
                'Pulau Derawan', 'Maratua', 'Biduk-Biduk', 'Batu Putih',
                'Talisayan', 'Tabalar', 'Kelay', 'Segah', 'Biatan'
            ]],
            ['name' => 'Kabupaten Mahakam Ulu', 'kecamatan' => [
                'Long Bagun', 'Long Hubung', 'Laham', 'Long Apari', 'Long Pahangai'
            ]],
        ];

        foreach ($cities as $cityData) {
            $cityId = DB::table('cities')->insertGetId([
                'province_id' => $provId,
                'name' => $cityData['name']
            ]);

            foreach ($cityData['kecamatan'] as $kecamatan) {
                DB::table('districts')->insert([
                    'city_id' => $cityId,
                    'name' => $kecamatan
                ]);
            }
        }

        $this->command->info('✅ Data Kalimantan Timur berhasil di-seed: 1 provinsi, 10 kab/kota, 105 kecamatan');
    }
}
