<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('angket_responden', function (Blueprint $table) {
            $table->id();
            
            // Meta data
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade');
            $table->integer('year')->default(date('Y'));
            
            // A. Identitas (9 fields)
            $table->string('nama');
            $table->enum('jenis_kelamin', ['pria', 'wanita']);
            $table->date('tanggal_lahir');
            $table->string('desa_kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->integer('tinggi_badan')->comment('cm');
            $table->decimal('berat_badan', 5, 2)->comment('kg');
            $table->enum('pendidikan', ['sd', 'smp', 'sma', 'pt']);
            $table->enum('pekerjaan', ['pns', 'mhs_pelajar', 'petani', 'tni_polri', 'pedagang', 'wirausaha', 'karyawan', 'lainnya']);
            $table->enum('pendapatan', ['0', '<2juta', '2-5juta', '5-9juta', '9-14juta', '14-20juta', '>20juta']);
            
            // B. Literasi Fisik (7 fields)
            $table->enum('literasi_frekuensi', ['1', '2', '3', '4'])->comment('kali/minggu');
            $table->enum('literasi_durasi', ['10', '30', '45', '60'])->comment('menit');
            $table->enum('literasi_intensitas', ['ringan', 'sedang', 'cukup_berat', 'berat']);
            $table->tinyInteger('literasi_kesenangan')->unsigned()->check('literasi_kesenangan between 1 and 5');
            $table->tinyInteger('literasi_membaca')->unsigned()->check('literasi_membaca between 1 and 5');
            $table->tinyInteger('literasi_menonton')->unsigned()->check('literasi_menonton between 1 and 5');
            $table->tinyInteger('literasi_murah')->unsigned()->check('literasi_murah between 1 and 5');
            
            // C. Partisipasi (7 fields, nullable for conditional)
            $table->enum('partisipasi_minggu_lalu', ['ya', 'tidak']);
            $table->enum('partisipasi_frekuensi', ['1', '2', '3', '4', '5+'])->nullable();
            $table->enum('partisipasi_durasi', ['0-20', '21-30', '31-45', '46-60', '60+'])->nullable();
            $table->tinyInteger('partisipasi_intensitas')->unsigned()->nullable()->check('partisipasi_intensitas between 1 and 5');
            $table->string('partisipasi_jenis')->nullable()->comment('jenis olahraga');
            $table->string('partisipasi_tujuan')->nullable()->comment('tujuan olahraga');
            $table->string('partisipasi_tempat')->nullable()->comment('tempat olahraga');
            
            // D. Perkembangan Personal (6 fields)
            $table->tinyInteger('personal_tantangan')->unsigned()->check('personal_tantangan between 1 and 5');
            $table->tinyInteger('personal_putus_asa')->unsigned()->check('personal_putus_asa between 1 and 5');
            $table->tinyInteger('personal_solusi')->unsigned()->check('personal_solusi between 1 and 5');
            $table->tinyInteger('personal_pertemuan')->unsigned()->check('personal_pertemuan between 1 and 5');
            $table->tinyInteger('personal_curiga')->unsigned()->check('personal_curiga between 1 and 5');
            $table->tinyInteger('personal_percaya')->unsigned()->check('personal_percaya between 1 and 5');
            
            // E. Kesehatan (6 fields)
            $table->tinyInteger('kesehatan_gangguan')->unsigned()->check('kesehatan_gangguan between 1 and 5');
            $table->tinyInteger('kesehatan_puas')->unsigned()->check('kesehatan_puas between 1 and 5');
            $table->tinyInteger('kesehatan_kesiapan')->unsigned()->check('kesehatan_kesiapan between 1 and 5');
            $table->tinyInteger('kesehatan_yakin')->unsigned()->check('kesehatan_yakin between 1 and 5');
            $table->tinyInteger('kesehatan_karakter')->unsigned()->check('kesehatan_karakter between 1 and 5');
            $table->tinyInteger('kesehatan_tujuan')->unsigned()->check('kesehatan_tujuan between 1 and 5');
            
            // F. Ekonomi (4 fields, nullable for conditional)
            $table->enum('ekonomi_belanja', ['ya', 'tidak']);
            $table->string('ekonomi_budget')->nullable()->comment('<200rb, 200-499rb, dll');
            $table->json('ekonomi_barang_dibeli')->nullable()->comment('JSON array: ["sepatu","pakaian"]');
            $table->json('ekonomi_jasa_dibayar')->nullable()->comment('JSON array: ["tiket","tv_berbayar"]');
            
            // G. Kebugaran (3 fields)
            $table->string('kebugaran_level')->nullable()->comment('Level/Tingkat Kebugaran');
            $table->string('kebugaran_balikan')->nullable()->comment('Balikan');
            $table->string('kebugaran_vo2max')->nullable()->comment('Vo2Max');
            
            // Status & timestamps
            $table->enum('status', ['draft', 'submitted'])->default('draft');
            $table->timestamps();
            
            // Unique constraint - one person per district per year
            $table->unique(['district_id', 'year', 'nama', 'tanggal_lahir'], 'unique_responden_district_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('angket_responden');
    }
};
