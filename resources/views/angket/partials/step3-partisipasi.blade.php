<div id="step3" class="step-content" style="padding: 24px 24px 0;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        C. PARTISIPASI
    </h5>
    
    <div style="background: var(--blue-100); border: 1px solid var(--blue); border-radius: var(--r-md); padding: 14px; margin-bottom: 24px;">
        <small style="font-size: 12px; color: var(--blue);">
            <strong>Catatan:</strong> Pertanyaan berikutnya akan muncul tergantung jawaban Anda pada pertanyaan pertama.
        </small>
    </div>
    
    <!-- Question 1: Minggu Lalu Olahraga? -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            1. Apakah dalam satu minggu terakhir, Anda melakukan olahraga? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            @foreach(['ya' => 'Ya', 'tidak' => 'Tidak'] as $val => $label)
                <label style="display: flex; align-items: center; gap: 10px; padding: 12px 20px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white); min-width: 120px;">
                    <input type="radio" name="partisipasi_minggu_lalu" value="{{ $val }}" required
                           {{ ($responden?->partisipasi_minggu_lalu ?? old('partisipasi_minggu_lalu')) === $val ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 13px; color: var(--ink); font-weight: 600;">{{ $label }}</span>
                </label>
            @endforeach
        </div>
        @error('partisipasi_minggu_lalu')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <hr style="border: 0; border-top: 1px solid var(--border); margin: 28px 0;">
    
    <!-- Conditional Fields (shown if "Ya") -->
    <div data-conditional="partisipasi">
        <!-- Question 2: Frekuensi -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                2. Berapa kali Anda berolahraga/melakukan aktivitas fisik dalam seminggu?
            </label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px;">
                @foreach(['1' => 'Satu Kali', '2' => 'Dua Kali', '3' => 'Tiga Kali', '4' => 'Empat Kali', '5+' => 'Lima Kali atau Lebih'] as $val => $label)
                    <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                        <input type="radio" name="partisipasi_frekuensi" value="{{ $val }}"
                               {{ ($responden?->partisipasi_frekuensi ?? old('partisipasi_frekuensi')) === $val ? 'checked' : '' }}
                               style="margin: 0;">
                        <span style="font-size: 12px; color: var(--ink);">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('partisipasi_frekuensi')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 3: Durasi -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                3. Berapa menit waktu yang Anda gunakan dalam setiap kali berolahraga/aktivitas fisik?
            </label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px;">
                @foreach(['0-20' => '0-20 Menit', '21-30' => '21-30 Menit', '31-45' => '31-45 Menit', '46-60' => '46-60 Menit', '60+' => '60 Menit Lebih'] as $val => $label)
                    <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                        <input type="radio" name="partisipasi_durasi" value="{{ $val }}"
                               {{ ($responden?->partisipasi_durasi ?? old('partisipasi_durasi')) === $val ? 'checked' : '' }}
                               style="margin: 0;">
                        <span style="font-size: 12px; color: var(--ink);">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('partisipasi_durasi')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 4: Intensitas (Scale 1-5) -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                4. Jika diukur dengan skala 1-5, seberapa intens Anda melakukan olahraga/aktivitas fisik?
            </label>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <small style="font-size: 11px; color: var(--ink-3);">Sangat Ringan</small>
                <small style="font-size: 11px; color: var(--ink-3);">Berat</small>
            </div>
            <div style="display: flex; justify-content: space-between; gap: 8px;">
                @for($i = 1; $i <= 5; $i++)
                    <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                        <input type="radio" name="partisipasi_intensitas" value="{{ $i }}"
                               {{ ($responden?->partisipasi_intensitas ?? old('partisipasi_intensitas')) == $i ? 'checked' : '' }}
                               style="margin: 0;">
                        <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                    </label>
                @endfor
            </div>
            @error('partisipasi_intensitas')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 5: Jenis Olahraga -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                5. Jenis olahraga yang biasa dilakukan (pilih salah satu)
            </label>
            <select name="partisipasi_jenis" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; background: white;">
                <option value="">-- Pilih Jenis Olahraga --</option>
                @foreach([
                    'atletik' => 'Atletik (Jalan/Lari)',
                    'angkat_besi' => 'Angkat Besi',
                    'basket' => 'Bola Basket',
                    'voli' => 'Bola Voli',
                    'bulutangkis' => 'Bulutangkis',
                    'dayung' => 'Dayung',
                    'karate' => 'Karate',
                    'menembak' => 'Menembak',
                    'panahan' => 'Panahan',
                    'panjat_tebing' => 'Panjat Tebing',
                    'pencak_silat' => 'Pencak Silat',
                    'renang' => 'Renang',
                    'senam' => 'Senam',
                    'sepak_bola' => 'Sepak Bola',
                    'sepeda' => 'Sepeda',
                    'taekwondo' => 'Taekwondo',
                    'wushu' => 'Wushu',
                    'lainnya' => 'Lainnya'
                ] as $val => $label)
                    <option value="{{ $val }}" {{ ($responden?->partisipasi_jenis ?? old('partisipasi_jenis')) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('partisipasi_jenis')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 6: Tujuan -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                6. Tujuan utama Anda berolahraga (pilih salah satu)
            </label>
            <select name="partisipasi_tujuan" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; background: white;">
                <option value="">-- Pilih Tujuan --</option>
                @foreach([
                    'kesehatan' => 'Menjaga Kesehatan',
                    'stress' => 'Mengurangi/Melepas Stress',
                    'sosialisasi' => 'Bersosialisasi',
                    'tubuh_ideal' => 'Memiliki Tubuh Ideal',
                    'kesenangan' => 'Kesenangan',
                    'persahabatan' => 'Persahabatan',
                    'tantangan' => 'Menyukai Tantangan',
                    'atlet' => 'Menjadi Atlet',
                    'hadiah' => 'Mendapatkan Hadiah/Uang',
                    'lainnya' => 'Lainnya'
                ] as $val => $label)
                    <option value="{{ $val }}" {{ ($responden?->partisipasi_tujuan ?? old('partisipasi_tujuan')) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('partisipasi_tujuan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 7: Tempat -->
        <div style="margin-bottom: 0;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                7. Tempat Anda melakukan olahraga (pilih salah satu)
            </label>
            <select name="partisipasi_tempat" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; background: white;">
                <option value="">-- Pilih Tempat --</option>
                @foreach([
                    'rumah' => 'Di Rumah',
                    'sekolah' => 'Di Sekolah',
                    'tempat_kerja' => 'Di Tempat Kerja',
                    'klub' => 'Di Klub/Pusat Kebugaran',
                    'lapangan' => 'Di Lapangan/Ruang Terbuka/Jalan',
                    'lainnya' => 'Lainnya'
                ] as $val => $label)
                    <option value="{{ $val }}" {{ ($responden?->partisipasi_tempat ?? old('partisipasi_tempat')) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('partisipasi_tempat')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <style>
        @media (max-width: 576px) {
            #step3 [style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
            #step3 [style*="flex"] > label {
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
</div>
