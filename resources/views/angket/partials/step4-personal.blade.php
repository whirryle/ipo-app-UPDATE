<div id="step4" class="step-content" style="padding: 24px 24px 0;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        D. PERKEMBANGAN PERSONAL
    </h5>
    
    <!-- Question 1: Tantangan -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            1. Saya melihat kesulitan dalam hidup sebagai tantangan, bukan hambatan <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="personal_tantangan" value="{{ $i }}" required
                           {{ ($responden?->personal_tantangan ?? old('personal_tantangan')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('personal_tantangan')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 2: Putus Asa -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            2. Saya sering putus asa ketika menghadapi kesulitan <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="personal_putus_asa" value="{{ $i }}" required
                           {{ ($responden?->personal_putus_asa ?? old('personal_putus_asa')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('personal_putus_asa')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 3: Solusi -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            3. Saya terus berusaha mencari solusi meski sering juga gagal <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="personal_solusi" value="{{ $i }}" required
                           {{ ($responden?->personal_solusi ?? old('personal_solusi')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('personal_solusi')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 4: Pertemuan -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            4. Saya suka menghadiri pertemuan yang diadakan oleh warga sekitar <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="personal_pertemuan" value="{{ $i }}" required
                           {{ ($responden?->personal_pertemuan ?? old('personal_pertemuan')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('personal_pertemuan')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 5: Curiga -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            5. Saya sering curiga kepada orang lain yang sudah saya kenal <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="personal_curiga" value="{{ $i }}" required
                           {{ ($responden?->personal_curiga ?? old('personal_curiga')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('personal_curiga')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 6: Percaya -->
    <div style="margin-bottom: 0;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            6. Saya lebih percaya kepada orang lain sesama etnis, agama, dan status sosial <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Tidak Setuju</small>
            <small style="font-size: 11px; color: var(--ink-3);">Sangat Setuju</small>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 8px;">
            @for($i = 1; $i <= 5; $i++)
                <label style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                    <input type="radio" name="personal_percaya" value="{{ $i }}" required
                           {{ ($responden?->personal_percaya ?? old('personal_percaya')) == $i ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 14px; font-weight: 600; color: var(--ink);">{{ $i }}</span>
                </label>
            @endfor
        </div>
        @error('personal_percaya')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <style>
        @media (max-width: 576px) {
            #step4 [style*="flex; justify-content: space-between"] {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</div>
