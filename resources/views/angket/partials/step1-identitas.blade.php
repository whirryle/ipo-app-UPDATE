<div id="step1" class="step-content" style="padding: 0 24px;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        A. IDENTITAS
    </h5>
    
    <!-- Row 1: Nama & Jenis Kelamin -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Nama Lengkap <span style="color: var(--red);">*</span>
            </label>
            <input type="text" name="nama" id="nama" required
                   value="{{ $responden?->nama ?? old('nama') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('nama')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Jenis Kelamin <span style="color: var(--red);">*</span>
            </label>
            <select name="jenis_kelamin" id="jenis_kelamin" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="pria" {{ ($responden?->jenis_kelamin ?? old('jenis_kelamin')) === 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ ($responden?->jenis_kelamin ?? old('jenis_kelamin')) === 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
            @error('jenis_kelamin')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <!-- Row 2: Tanggal Lahir & Tinggi Badan -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Tanggal Lahir <span style="color: var(--red);">*</span>
            </label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                   value="{{ optional($responden)->tanggal_lahir?->format('Y-m-d') ?? old('tanggal_lahir') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('tanggal_lahir')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Tinggi Badan (Cm) <span style="color: var(--red);">*</span>
            </label>
            <input type="number" name="tinggi_badan" id="tinggi_badan" min="50" max="250" required
                   value="{{ $responden?->tinggi_badan ?? old('tinggi_badan') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('tinggi_badan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <!-- Row 3: Berat Badan & Pendidikan -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Berat Badan (Kg) <span style="color: var(--red);">*</span>
            </label>
            <input type="number" name="berat_badan" id="berat_badan" min="10" max="300" step="0.1" required
                   value="{{ $responden?->berat_badan ?? old('berat_badan') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('berat_badan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Pendidikan Tertinggi <span style="color: var(--red);">*</span>
            </label>
            <select name="pendidikan" id="pendidikan" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
                <option value="">-- Pilih Pendidikan --</option>
                <option value="sd" {{ ($responden?->pendidikan ?? old('pendidikan')) === 'sd' ? 'selected' : '' }}>SD</option>
                <option value="smp" {{ ($responden?->pendidikan ?? old('pendidikan')) === 'smp' ? 'selected' : '' }}>SMP</option>
                <option value="sma" {{ ($responden?->pendidikan ?? old('pendidikan')) === 'sma' ? 'selected' : '' }}>SMA</option>
                <option value="pt" {{ ($responden?->pendidikan ?? old('pendidikan')) === 'pt' ? 'selected' : '' }}>Perguruan Tinggi</option>
            </select>
            @error('pendidikan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <!-- Row 4: Pekerjaan & Pendapatan -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Pekerjaan <span style="color: var(--red);">*</span>
            </label>
            <select name="pekerjaan" id="pekerjaan" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
                <option value="">-- Pilih Pekerjaan --</option>
                <option value="pns" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'pns' ? 'selected' : '' }}>PNS</option>
                <option value="mhs_pelajar" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'mhs_pelajar' ? 'selected' : '' }}>Mahasiswa/Pelajar</option>
                <option value="petani" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'petani' ? 'selected' : '' }}>Petani</option>
                <option value="tni_polri" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'tni_polri' ? 'selected' : '' }}>TNI/Polri</option>
                <option value="pedagang" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'pedagang' ? 'selected' : '' }}>Pedagang</option>
                <option value="wirausaha" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                <option value="karyawan" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'karyawan' ? 'selected' : '' }}>Karyawan Swasta</option>
                <option value="lainnya" {{ ($responden?->pekerjaan ?? old('pekerjaan')) === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('pekerjaan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Pendapatan Rata-rata Sebulan <span style="color: var(--red);">*</span>
            </label>
            <select name="pendapatan" id="pendapatan" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
                <option value="">-- Pilih Pendapatan --</option>
                <option value="0" {{ ($responden?->pendapatan ?? old('pendapatan')) === '0' ? 'selected' : '' }}>Rp 0</option>
                <option value="<2juta" {{ ($responden?->pendapatan ?? old('pendapatan')) === '<2juta' ? 'selected' : '' }}>Kurang dari Rp 2 Juta</option>
                <option value="2-5juta" {{ ($responden?->pendapatan ?? old('pendapatan')) === '2-5juta' ? 'selected' : '' }}>Rp 2 - 5 Juta</option>
                <option value="5-9juta" {{ ($responden?->pendapatan ?? old('pendapatan')) === '5-9juta' ? 'selected' : '' }}>Rp 5 - 9 Juta</option>
                <option value="9-14juta" {{ ($responden?->pendapatan ?? old('pendapatan')) === '9-14juta' ? 'selected' : '' }}>Rp 9 - 14 Juta</option>
                <option value="14-20juta" {{ ($responden?->pendapatan ?? old('pendapatan')) === '14-20juta' ? 'selected' : '' }}>Rp 14 - 20 Juta</option>
                <option value=">20juta" {{ ($responden?->pendapatan ?? old('pendapatan')) === '>20juta' ? 'selected' : '' }}>Lebih dari Rp 20 Juta</option>
            </select>
            @error('pendapatan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <hr style="border: 0; border-top: 1px solid var(--border); margin: 28px 0;">
    
    <h6 style="font-size: 14px; font-weight: 600; color: var(--ink); margin-bottom: 16px;">Alamat Tempat Tinggal</h6>
    
    <!-- Row 5: Desa/Kelurahan & Kecamatan -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Desa/Kelurahan <span style="color: var(--red);">*</span>
            </label>
            <input type="text" name="desa_kelurahan" id="desa_kelurahan" required
                   value="{{ $responden?->desa_kelurahan ?? old('desa_kelurahan') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('desa_kelurahan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Kecamatan <span style="color: var(--red);">*</span>
            </label>
            <input type="text" name="kecamatan" id="kecamatan" required
                   value="{{ $responden?->kecamatan ?? old('kecamatan') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('kecamatan')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <!-- Row 6: Kabupaten/Kota & Provinsi -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 0;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Kabupaten/Kota <span style="color: var(--red);">*</span>
            </label>
            <input type="text" name="kabupaten_kota" id="kabupaten_kota" required
                   value="{{ $responden?->kabupaten_kota ?? old('kabupaten_kota') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('kabupaten_kota')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 8px;">
                Provinsi <span style="color: var(--red);">*</span>
            </label>
            <input type="text" name="provinsi" id="provinsi" required
                   value="{{ $responden?->provinsi ?? old('provinsi', 'Kalimantan Timur') }}"
                   style="width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: var(--r-sm); font-size: 13px; color: var(--ink); background: var(--white);">
            @error('provinsi')
                <span style="display: block; color: var(--red); font-size: 12px; margin-top: 6px;">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <style>
        @media (max-width: 768px) {
            #step1 > div[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</div>
