<div id="step6" class="step-content" style="padding: 24px 24px 0;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        F. EKONOMI
    </h5>
    
    <div style="background: var(--blue-100); border: 1px solid var(--blue); border-radius: var(--r-md); padding: 14px; margin-bottom: 24px;">
        <small style="font-size: 12px; color: var(--blue);">
            <strong>Catatan:</strong> Pertanyaan berikutnya akan muncul tergantung jawaban Anda pada pertanyaan pertama.
        </small>
    </div>
    
    <!-- Question 1: Belanja Barang Olahraga -->
    <div style="margin-bottom: 28px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
            1. Apa Anda membelanjakan uang untuk membeli barang kebutuhan olahraga dan atau menonton pertandingan/kejuaraan olahraga? <span style="color: var(--red);">*</span>
        </label>
        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            @foreach(['ya' => 'Ya', 'tidak' => 'Tidak'] as $val => $label)
                <label style="display: flex; align-items: center; gap: 10px; padding: 12px 20px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white); min-width: 120px;">
                    <input type="radio" name="ekonomi_belanja" value="{{ $val }}" required
                           {{ ($responden?->ekonomi_belanja ?? old('ekonomi_belanja')) === $val ? 'checked' : '' }}
                           style="margin: 0;">
                    <span style="font-size: 13px; color: var(--ink); font-weight: 600;">{{ $label }}</span>
                </label>
            @endforeach
        </div>
        @error('ekonomi_belanja')
            <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>
    
    <hr style="border: 0; border-top: 1px solid var(--border); margin: 28px 0;">
    
    <!-- Conditional Fields (shown if "Ya") -->
    <div data-conditional="ekonomi">
        <!-- Question 2: Jumlah Pengeluaran -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                2. Berapa kira-kira jumlah uang yang Anda keluarkan untuk membeli barang kebutuhan olahraga selama setahun?
            </label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px;">
                @foreach([
                    '<200rb' => 'Kurang dari 200 Ribu',
                    '200-499rb' => '200 - 499 Ribu',
                    '0.5-1jt' => '0,5 - 1 Juta',
                    '1.1-2jt' => '1,1 - 2 Juta',
                    '2.1-3jt' => '2,1 - 3 Juta',
                    '3.1-4jt' => '3,1 - 4 Juta',
                    '4.1-5jt' => '4,1 - 5 Juta',
                    '>5jt' => 'Lebih dari 5 Juta'
                ] as $val => $label)
                    <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                        <input type="radio" name="ekonomi_jumlah" value="{{ $val }}"
                               {{ ($responden?->ekonomi_jumlah ?? old('ekonomi_jumlah')) === $val ? 'checked' : '' }}
                               style="margin: 0;">
                        <span style="font-size: 11px; color: var(--ink);">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('ekonomi_jumlah')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 3: Barang Olahraga (Checkboxes) -->
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                3. Barang perlengkapan olahraga apa saja yang Anda beli? <span style="font-size: 11px; color: var(--ink-3);">(Pilihan boleh lebih dari satu)</span>
            </label>
            @php
                $selectedBarang = $responden?->ekonomi_barang ?? old('ekonomi_barang', []);
                if (is_string($selectedBarang)) {
                    $selectedBarang = json_decode($selectedBarang, true) ?? [];
                }
            @endphp
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;">
                @foreach([
                    'sepatu' => 'Sepatu',
                    'pakaian' => 'Pakaian',
                    'peralatan' => 'Peralatan',
                    'aksesoris' => 'Aksesoris',
                    'makan_minum' => 'Biaya Makan Minum',
                    'suplemen' => 'Suplemen/Nutrisi',
                    'buku' => 'Buku/Majalah/Koran',
                    'cindera_mata' => 'Cindera Mata'
                ] as $val => $label)
                    <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                        <input type="checkbox" name="ekonomi_barang[]" value="{{ $val }}"
                               {{ in_array($val, $selectedBarang) ? 'checked' : '' }}
                               style="margin: 0;">
                        <span style="font-size: 12px; color: var(--ink);">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('ekonomi_barang')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Question 4: Jasa Olahraga (Checkboxes) -->
        <div style="margin-bottom: 0;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 12px;">
                4. Jasa olahraga apa saja yang Anda bayar? <span style="font-size: 11px; color: var(--ink-3);">(Pilihan boleh lebih dari satu)</span>
            </label>
            @php
                $selectedJasa = $responden?->ekonomi_jasa ?? old('ekonomi_jasa', []);
                if (is_string($selectedJasa)) {
                    $selectedJasa = json_decode($selectedJasa, true) ?? [];
                }
            @endphp
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;">
                @foreach([
                    'tiket' => 'Tiket Pertandingan',
                    'tv_berbayar' => 'Langganan TV Berbayar',
                    'pelatih' => 'Membayar Pelatih',
                    'tempat_latihan' => 'Membayar Tempat Latihan',
                    'sewa_peralatan' => 'Sewa Peralatan',
                    'perjalanan' => 'Biaya Perjalanan',
                    'paramedik' => 'Jasa Paramedik'
                ] as $val => $label)
                    <label style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--r-sm); cursor: pointer; background: var(--white);">
                        <input type="checkbox" name="ekonomi_jasa[]" value="{{ $val }}"
                               {{ in_array($val, $selectedJasa) ? 'checked' : '' }}
                               style="margin: 0;">
                        <span style="font-size: 12px; color: var(--ink);">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('ekonomi_jasa')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 8px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <style>
        @media (max-width: 576px) {
            #step6 [style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
            #step6 [style*="flex"] > label {
                font-size: 11px;
                padding: 10px;
            }
        }
    </style>
</div>
