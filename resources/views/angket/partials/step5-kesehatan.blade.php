<div id="step5" class="step-content" style="padding: 24px 24px 0;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        E. KESEHATAN
    </h5>
    
    <!-- Question 1: Gangguan Kesehatan -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            1. Seberapa sering Anda mengalami gangguan kesehatan/sakit? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Sering</small>
            <small style="font-size: 11px; color: var(--ink-3);">Tidak Pernah</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="kesehatan_gangguan" value="{{ $i }}" required
                           {{ ($responden?->kesehatan_gangguan ?? old('kesehatan_gangguan')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('kesehatan_gangguan')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 2: Kepuasan Kesehatan -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            2. Seberapa puas Anda dengan kesehatan Anda? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Puas</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Puas</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="kesehatan_puas" value="{{ $i }}" required
                           {{ ($responden?->kesehatan_puas ?? old('kesehatan_puas')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('kesehatan_puas')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 3: Kesiapan Fisik -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            3. Bagaimana kesiapan fisik Anda untuk melakukan aktivitas harian? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Baik</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Baik</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="kesehatan_kesiapan" value="{{ $i }}" required
                           {{ ($responden?->kesehatan_kesiapan ?? old('kesehatan_kesiapan')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('kesehatan_kesiapan')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 4: Keyakinan -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            4. Saya yakin terhadap apa yang saya lakukan meski tidak semua orang setuju <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="kesehatan_yakin" value="{{ $i }}" required
                           {{ ($responden?->kesehatan_yakin ?? old('kesehatan_yakin')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('kesehatan_yakin')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 5: Karakter Pribadi -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            5. Saya tidak menyukai karakter pribadi saya <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="kesehatan_karakter" value="{{ $i }}" required
                           {{ ($responden?->kesehatan_karakter ?? old('kesehatan_karakter')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('kesehatan_karakter')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 6: Tujuan Hidup -->
    <div style="margin-bottom: 0;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            6. Banyak orang melakukan sesuatu tanpa tujuan yang jelas, tapi saya bukan bagian dari mereka <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="kesehatan_tujuan" value="{{ $i }}" required
                           {{ ($responden?->kesehatan_tujuan ?? old('kesehatan_tujuan')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('kesehatan_tujuan')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <style>
        @media (max-width: 576px) {
            #step5 [style*="flex; justify-content: space-between"] {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</div>
