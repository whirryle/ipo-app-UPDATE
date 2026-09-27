<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('angket_responden', function (Blueprint $table) {
            // B. Literasi Fisik - make nullable for progressive wizard
            $table->enum('literasi_frekuensi', ['1', '2', '3', '4'])->nullable()->change();
            $table->enum('literasi_durasi', ['10', '30', '45', '60'])->nullable()->change();
            $table->enum('literasi_intensitas', ['ringan', 'sedang', 'cukup_berat', 'berat'])->nullable()->change();
            $table->tinyInteger('literasi_kesenangan')->unsigned()->nullable()->change();
            $table->tinyInteger('literasi_membaca')->unsigned()->nullable()->change();
            $table->tinyInteger('literasi_menonton')->unsigned()->nullable()->change();
            $table->tinyInteger('literasi_murah')->unsigned()->nullable()->change();
            
            // C. Partisipasi - already nullable except first field
            $table->enum('partisipasi_minggu_lalu', ['ya', 'tidak'])->nullable()->change();
            
            // D. Perkembangan Personal - make nullable
            $table->tinyInteger('personal_tantangan')->unsigned()->nullable()->change();
            $table->tinyInteger('personal_putus_asa')->unsigned()->nullable()->change();
            $table->tinyInteger('personal_solusi')->unsigned()->nullable()->change();
            $table->tinyInteger('personal_pertemuan')->unsigned()->nullable()->change();
            $table->tinyInteger('personal_curiga')->unsigned()->nullable()->change();
            $table->tinyInteger('personal_percaya')->unsigned()->nullable()->change();
            
            // E. Kesehatan - make nullable
            $table->tinyInteger('kesehatan_gangguan')->unsigned()->nullable()->change();
            $table->tinyInteger('kesehatan_puas')->unsigned()->nullable()->change();
            $table->tinyInteger('kesehatan_kesiapan')->unsigned()->nullable()->change();
            $table->tinyInteger('kesehatan_yakin')->unsigned()->nullable()->change();
            $table->tinyInteger('kesehatan_karakter')->unsigned()->nullable()->change();
            $table->tinyInteger('kesehatan_tujuan')->unsigned()->nullable()->change();
            
            // F. Ekonomi - already mostly nullable
            $table->enum('ekonomi_belanja', ['ya', 'tidak'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('angket_responden', function (Blueprint $table) {
            // Revert to NOT NULL
            $table->enum('literasi_frekuensi', ['1', '2', '3', '4'])->change();
            $table->enum('literasi_durasi', ['10', '30', '45', '60'])->change();
            $table->enum('literasi_intensitas', ['ringan', 'sedang', 'cukup_berat', 'berat'])->change();
            $table->tinyInteger('literasi_kesenangan')->unsigned()->change();
            $table->tinyInteger('literasi_membaca')->unsigned()->change();
            $table->tinyInteger('literasi_menonton')->unsigned()->change();
            $table->tinyInteger('literasi_murah')->unsigned()->change();
            
            $table->enum('partisipasi_minggu_lalu', ['ya', 'tidak'])->change();
            
            $table->tinyInteger('personal_tantangan')->unsigned()->change();
            $table->tinyInteger('personal_putus_asa')->unsigned()->change();
            $table->tinyInteger('personal_solusi')->unsigned()->change();
            $table->tinyInteger('personal_pertemuan')->unsigned()->change();
            $table->tinyInteger('personal_curiga')->unsigned()->change();
            $table->tinyInteger('personal_percaya')->unsigned()->change();
            
            $table->tinyInteger('kesehatan_gangguan')->unsigned()->change();
            $table->tinyInteger('kesehatan_puas')->unsigned()->change();
            $table->tinyInteger('kesehatan_kesiapan')->unsigned()->change();
            $table->tinyInteger('kesehatan_yakin')->unsigned()->change();
            $table->tinyInteger('kesehatan_karakter')->unsigned()->change();
            $table->tinyInteger('kesehatan_tujuan')->unsigned()->change();
            
            $table->enum('ekonomi_belanja', ['ya', 'tidak'])->change();
        });
    }
};
