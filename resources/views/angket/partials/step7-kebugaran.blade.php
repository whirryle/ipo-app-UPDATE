<div id="step7" class="step-content" style="padding: 24px 24px 0;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        G. KEBUGARAN
    </h5>
    
    <div style="background: var(--blue-100); border: 1px solid var(--blue); border-radius: var(--r-md); padding: 14px; margin-bottom: 24px;">
        <small style="font-size: 12px; color: var(--blue);">
            <strong>Catatan:</strong> Bagian ini berisi data hasil tes kebugaran fisik responden.
        </small>
    </div>
    
    <!-- Question 1: Level Kebugaran -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            1. Level/Tingkat Kebugaran <span style="color: var(--red);">*</span>
        </label>
        <input type="text" name="kebugaran_level"
               placeholder="Contoh: Baik, Sedang, Kurang, dll"
               value="{{ $responden?->kebugaran_level ?? old('kebugaran_level') }}" required
               style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; background: white;">
        <small style="display: block; font-size: 11px; color: var(--ink-3); margin-top: 8px;">
            Masukkan tingkat kebugaran responden berdasarkan hasil tes
        </small>
        @error('kebugaran_level')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Question 2 & 3: Balikan & Vo2Max (2-column grid) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 0;">
        <!-- Question 2: Balikan -->
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                2. Balikan <span style="color: var(--red);">*</span>
            </label>
            <input type="text" name="kebugaran_balikan"
                   placeholder="Contoh: 12.5 detik"
                   value="{{ $responden?->kebugaran_balikan ?? old('kebugaran_balikan') }}" required
                   style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; background: white;">
            <small style="display: block; font-size: 11px; color: var(--ink-3); margin-top: 8px;">
                Hasil tes lari balikan (shuttle run)
            </small>
            @error('kebugaran_balikan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 3: Vo2Max -->
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                3. Vo2Max <span style="color: var(--red);">*</span>
            </label>
            <input type="text" name="kebugaran_vo2max"
                   placeholder="Contoh: 42.5 ml/kg/min"
                   value="{{ $responden?->kebugaran_vo2max ?? old('kebugaran_vo2max') }}" required
                   style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; background: white;">
            <small style="display: block; font-size: 11px; color: var(--ink-3); margin-top: 8px;">
                Kapasitas oksigen maksimal (VO2 Max)
            </small>
            @error('kebugaran_vo2max')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div style="background: var(--yellow-100); border: 1px solid var(--yellow); border-radius: var(--r-md); padding: 14px; margin-top: 28px;">
        <small style="font-size: 12px; color: var(--yellow);">
            <strong>⚠️ Penting:</strong> Pastikan data kebugaran diisi berdasarkan hasil tes fisik yang valid.
        </small>
    </div>
    
    <style>
        @media (max-width: 576px) {
            #step7 [style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</div>
