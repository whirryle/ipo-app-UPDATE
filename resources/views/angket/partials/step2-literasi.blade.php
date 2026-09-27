<div id="step2" class="step-content" style="padding: 24px 24px 0;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        B. LITERASI FISIK
    </h5>
    
    <!-- Question 1: Frekuensi -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            1. Berapa kali sekurang-kurangnya Anda melakukan olahraga/aktivitas fisik dalam seminggu? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px;">
            @foreach(['1' => '1 Kali', '2' => '2 Kali', '3' => '3 Kali', '4' => '4 Kali'] as $val => $label)
                <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="literasi_frekuensi" value="{{ $val }}" required
                           {{ ($responden?->literasi_frekuensi ?? old('literasi_frekuensi')) === $val ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 13px; color: var(--ink);">{{ $label }}</span>
                </label>
            @endforeach
        </div>
        @error('literasi_frekuensi')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 2: Durasi -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            2. Berapa menit minimal waktu yang dibutuhkan dalam setiap kali melakukan olahraga/aktivitas fisik? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 12px;">
            @foreach(['10' => "10'", '30' => "30'", '45' => "45'", '60' => "60'"] as $val => $label)
                <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="literasi_durasi" value="{{ $val }}" required
                           {{ ($responden?->literasi_durasi ?? old('literasi_durasi')) === $val ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 13px; color: var(--ink);">{{ $label }}</span>
                </label>
            @endforeach
        </div>
        @error('literasi_durasi')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 3: Intensitas -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            3. Bagaimana intensitas aktivitas olahraga/aktivitas fisik yang dilakukan? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px;">
            @foreach(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'cukup_berat' => 'Cukup Berat', 'berat' => 'Berat'] as $val => $label)
                <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="literasi_intensitas" value="{{ $val }}" required
                           {{ ($responden?->literasi_intensitas ?? old('literasi_intensitas')) === $val ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 13px; color: var(--ink);">{{ $label }}</span>
                </label>
            @endforeach
        </div>
        @error('literasi_intensitas')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <hr style="border: 0; border-top: 1px solid var(--border); margin: 28px 0;">
    
    <!-- Question 4: Kesenangan (Scale 1-5) -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            4. Sampai seberapa kesenangan Anda terhadap olahraga/aktivitas fisik? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Senang</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Senang</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="literasi_kesenangan" value="{{ $i }}" required
                           {{ ($responden?->literasi_kesenangan ?? old('literasi_kesenangan')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('literasi_kesenangan')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 5: Membaca (Scale 1-5) -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            5. Apa Anda suka membaca buku/majalah/koran terkait olahraga? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Suka</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Suka</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="literasi_membaca" value="{{ $i }}" required
                           {{ ($responden?->literasi_membaca ?? old('literasi_membaca')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('literasi_membaca')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 6: Menonton (Scale 1-5) -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            6. Apa Anda suka melihat pertandingan/kejuaraan olahraga? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Suka</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Suka</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="literasi_menonton" value="{{ $i }}" required
                           {{ ($responden?->literasi_menonton ?? old('literasi_menonton')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('literasi_menonton')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 7: Murah (Scale 1-5) -->
    <div style="margin-bottom: 0;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            7. Olahraga merupakan cara murah dan mudah untuk menjaga kesehatan <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="literasi_murah" value="{{ $i }}" required
                           {{ ($responden?->literasi_murah ?? old('literasi_murah')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('literasi_murah')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <style>
        @media (max-width: 576px) {
            #step2 [style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
            #step2 [style*="flex"] > label {
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
</div>
