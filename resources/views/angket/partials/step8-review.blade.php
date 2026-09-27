<div id="step8" class="step-content" style="padding: 24px 24px 0;">
    <h5 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid var(--border);">
        REVIEW & KONFIRMASI
    </h5>
    
    <div style="background: var(--green-100); border: 1px solid var(--green); border-radius: var(--r-md); padding: 14px; margin-bottom: 24px;">
        <small style="font-size: 12px; color: var(--green); font-weight: 600;">
            Hampir Selesai! Silakan review semua data yang telah Anda isi sebelum submit.
        </small>
    </div>
    
    <!-- A. IDENTITAS -->
    <div style="border: 1px solid var(--brand-700); border-radius: var(--r-sm); margin-bottom: 16px; overflow: hidden;">
        <div style="background: var(--brand-700); color: #fff; padding: 12px 16px; font-size: 13px; font-weight: 700;">
            A. IDENTITAS
        </div>
        <div style="padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Nama:</strong> <span id="review_nama" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Jenis Kelamin:</strong> <span id="review_jenis_kelamin" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Tanggal Lahir:</strong> <span id="review_tanggal_lahir" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Tinggi Badan:</strong> <span id="review_tinggi_badan" style="color: var(--ink-3);">-</span> Cm</p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Berat Badan:</strong> <span id="review_berat_badan" style="color: var(--ink-3);">-</span> Kg</p>
            </div>
            <div>
                <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Pendidikan:</strong> <span id="review_pendidikan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Pekerjaan:</strong> <span id="review_pekerjaan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Pendapatan:</strong> <span id="review_pendapatan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;">
                    <strong style="color: var(--ink);">Alamat:</strong><br>
                    <span id="review_desa_kelurahan" style="color: var(--ink-3);">-</span>, 
                    <span id="review_kecamatan" style="color: var(--ink-3);">-</span>, 
                    <span id="review_kabupaten_kota" style="color: var(--ink-3);">-</span>, 
                    <span id="review_provinsi" style="color: var(--ink-3);">-</span>
                </p>
            </div>
        </div>
    </div>
    
    <!-- B. LITERASI FISIK -->
    <div style="border: 1px solid var(--blue); border-radius: var(--r-sm); margin-bottom: 16px; overflow: hidden;">
        <div style="background: var(--blue); color: #fff; padding: 12px 16px; font-size: 13px; font-weight: 700;">
            B. LITERASI FISIK
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                <p style="margin: 0;"><strong style="color: var(--ink);">Frekuensi:</strong> <span id="review_literasi_frekuensi" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Durasi:</strong> <span id="review_literasi_durasi" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Intensitas:</strong> <span id="review_literasi_intensitas" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Kesenangan (1-5):</strong> <span id="review_literasi_kesenangan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Membaca (1-5):</strong> <span id="review_literasi_membaca" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Menonton (1-5):</strong> <span id="review_literasi_menonton" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Olahraga Murah & Mudah (1-5):</strong> <span id="review_literasi_murah" style="color: var(--ink-3);">-</span></p>
            </div>
        </div>
    </div>
    
    <!-- C. PARTISIPASI -->
    <div style="border: 1px solid var(--green); border-radius: var(--r-sm); margin-bottom: 16px; overflow: hidden;">
        <div style="background: var(--green); color: #fff; padding: 12px 16px; font-size: 13px; font-weight: 700;">
            C. PARTISIPASI
        </div>
        <div style="padding: 20px;">
            <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Olahraga Minggu Lalu:</strong> <span id="review_partisipasi_minggu_lalu" style="color: var(--ink-3);">-</span></p>
            <div id="review_partisipasi_detail">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-top: 12px;">
                    <p style="margin: 0;"><strong style="color: var(--ink);">Frekuensi:</strong> <span id="review_partisipasi_frekuensi" style="color: var(--ink-3);">-</span></p>
                    <p style="margin: 0;"><strong style="color: var(--ink);">Durasi:</strong> <span id="review_partisipasi_durasi" style="color: var(--ink-3);">-</span></p>
                    <p style="margin: 0;"><strong style="color: var(--ink);">Intensitas (1-5):</strong> <span id="review_partisipasi_intensitas" style="color: var(--ink-3);">-</span></p>
                    <p style="margin: 0;"><strong style="color: var(--ink);">Jenis Olahraga:</strong> <span id="review_partisipasi_jenis" style="color: var(--ink-3);">-</span></p>
                    <p style="margin: 0;"><strong style="color: var(--ink);">Tujuan:</strong> <span id="review_partisipasi_tujuan" style="color: var(--ink-3);">-</span></p>
                    <p style="margin: 0;"><strong style="color: var(--ink);">Tempat:</strong> <span id="review_partisipasi_tempat" style="color: var(--ink-3);">-</span></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- D. PERKEMBANGAN PERSONAL -->
    <div style="border: 1px solid var(--yellow); border-radius: var(--r-sm); margin-bottom: 16px; overflow: hidden;">
        <div style="background: var(--yellow); color: #000; padding: 12px 16px; font-size: 13px; font-weight: 700;">
            D. PERKEMBANGAN PERSONAL
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                <p style="margin: 0;"><strong style="color: var(--ink);">Tantangan (1-5):</strong> <span id="review_personal_tantangan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Putus Asa (1-5):</strong> <span id="review_personal_putus_asa" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Solusi (1-5):</strong> <span id="review_personal_solusi" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Pertemuan (1-5):</strong> <span id="review_personal_pertemuan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Curiga (1-5):</strong> <span id="review_personal_curiga" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Percaya (1-5):</strong> <span id="review_personal_percaya" style="color: var(--ink-3);">-</span></p>
            </div>
        </div>
    </div>
    
    <!-- E. KESEHATAN -->
    <div style="border: 1px solid var(--red); border-radius: var(--r-sm); margin-bottom: 16px; overflow: hidden;">
        <div style="background: var(--red); color: #fff; padding: 12px 16px; font-size: 13px; font-weight: 700;">
            E. KESEHATAN
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                <p style="margin: 0;"><strong style="color: var(--ink);">Gangguan (1-5):</strong> <span id="review_kesehatan_gangguan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Kepuasan (1-5):</strong> <span id="review_kesehatan_puas" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Kesiapan Fisik (1-5):</strong> <span id="review_kesehatan_kesiapan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Keyakinan (1-5):</strong> <span id="review_kesehatan_yakin" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Karakter (1-5):</strong> <span id="review_kesehatan_karakter" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Tujuan (1-5):</strong> <span id="review_kesehatan_tujuan" style="color: var(--ink-3);">-</span></p>
            </div>
        </div>
    </div>
    
    <!-- F. EKONOMI -->
    <div style="border: 1px solid var(--ink-3); border-radius: var(--r-sm); margin-bottom: 16px; overflow: hidden;">
        <div style="background: var(--ink-3); color: #fff; padding: 12px 16px; font-size: 13px; font-weight: 700;">
            F. EKONOMI
        </div>
        <div style="padding: 20px;">
            <p style="margin: 0 0 8px;"><strong style="color: var(--ink);">Belanja Barang Olahraga:</strong> <span id="review_ekonomi_belanja" style="color: var(--ink-3);">-</span></p>
            <div id="review_ekonomi_detail">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-top: 12px;">
                    <p style="margin: 0;"><strong style="color: var(--ink);">Jumlah Pengeluaran:</strong> <span id="review_ekonomi_jumlah" style="color: var(--ink-3);">-</span></p>
                    <p style="margin: 0;"><strong style="color: var(--ink);">Barang yang Dibeli:</strong> <span id="review_ekonomi_barang" style="color: var(--ink-3);">-</span></p>
                    <p style="margin: 0;"><strong style="color: var(--ink);">Jasa yang Dibayar:</strong> <span id="review_ekonomi_jasa" style="color: var(--ink-3);">-</span></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- G. KEBUGARAN -->
    <div style="border: 1px solid var(--ink); border-radius: var(--r-sm); margin-bottom: 24px; overflow: hidden;">
        <div style="background: var(--ink); color: #fff; padding: 12px 16px; font-size: 13px; font-weight: 700;">
            G. KEBUGARAN
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                <p style="margin: 0;"><strong style="color: var(--ink);">Level/Tingkat:</strong> <span id="review_kebugaran_level" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Balikan:</strong> <span id="review_kebugaran_balikan" style="color: var(--ink-3);">-</span></p>
                <p style="margin: 0;"><strong style="color: var(--ink);">Vo2Max:</strong> <span id="review_kebugaran_vo2max" style="color: var(--ink-3);">-</span></p>
            </div>
        </div>
    </div>
    
    <div style="background: var(--blue-100); border: 1px solid var(--blue); border-radius: var(--r-md); padding: 14px;">
        <small style="font-size: 12px; color: var(--blue);">
            Jika ada data yang perlu diperbaiki, gunakan tombol <strong>"Kembali"</strong> untuk mengedit.
        </small>
    </div>
</div>
