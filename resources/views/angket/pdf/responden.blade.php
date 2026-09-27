<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Angket Responden - {{ $responden->nama }}</title>
    <style>
        @page {
            margin: 1.5cm;
            size: A4;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }
        
        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 3px 0;
        }
        
        .header h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
        }
        
        .header p {
            font-size: 10pt;
            margin: 2px 0;
        }
        
        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 1px solid #000;
        }
        
        .question {
            margin-bottom: 10px;
            padding-left: 15px;
        }
        
        .question-num {
            font-weight: bold;
            display: inline-block;
            width: 25px;
        }
        
        .question-text {
            display: inline;
        }
        
        .answer-row {
            margin-left: 30px;
            margin-top: 5px;
            margin-bottom: 8px;
        }
        
        .checkbox-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        
        .checkbox {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #000;
            text-align: center;
            line-height: 14px;
            font-size: 10pt;
            font-weight: bold;
            margin-right: 6px;
        }
        
        .checkbox.checked {
            background-color: #000;
            color: #fff;
        }
        
        .scale-row {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            margin-bottom: 8px;
        }
        
        .scale-box {
            flex: 1;
            text-align: center;
            border: 1px solid #000;
            padding: 6px 4px;
            margin: 0 3px;
            font-size: 10pt;
        }
        
        .scale-box.selected {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }
        
        .scale-label {
            text-align: center;
            font-size: 9pt;
            margin-top: 2px;
        }
        
        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 200px;
            margin: 0 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table td {
            padding: 3px 5px;
            vertical-align: top;
        }
        
        .signature-section {
            margin-top: 25px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            padding: 12px;
            border: 1px solid #000;
        }
        
        .signature-box p {
            margin: 5px 0;
            font-size: 10pt;
        }
        
        .footer {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
            font-size: 9pt;
            font-style: italic;
        }
        
        .conditional-hidden {
            display: none;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>ANGKET RESPONDEN</h1>
        <h2>Indeks Prestasi Olahraga (IPO)</h2>
        <p>Kalimantan Timur</p>
    </div>
    
    <!-- A. IDENTITAS -->
    <div class="section">
        <div class="section-title">A. IDENTITAS</div>
        
        <div class="question">
            <span class="question-num">1.</span>
            <span class="question-text">Nama: <span class="dotted-line">{{ $responden->nama }}</span></span>
        </div>
        
        <div class="question">
            <span class="question-num">2.</span>
            <span class="question-text">Jenis Kelamin</span>
            <div class="answer-row">
                <div class="checkbox-item">
                    <span class="checkbox {{ $responden->jenis_kelamin === 'pria' ? 'checked' : '' }}">
                        {{ $responden->jenis_kelamin === 'pria' ? '✓' : '' }}
                    </span>
                    Pria
                </div>
                <div class="checkbox-item">
                    <span class="checkbox {{ $responden->jenis_kelamin === 'wanita' ? 'checked' : '' }}">
                        {{ $responden->jenis_kelamin === 'wanita' ? '✓' : '' }}
                    </span>
                    Wanita
                </div>
            </div>
        </div>
        
        <div class="question">
            <span class="question-num">3.</span>
            <span class="question-text">Tanggal Lahir: <span class="dotted-line">{{ $responden->tanggal_lahir?->format('d-m-Y') }}</span></span>
        </div>
        
        <div class="question">
            <span class="question-num">4.</span>
            <span class="question-text">Alamat tempat tinggal:</span>
            <div class="answer-row">
                Desa/Kelurahan: <span class="dotted-line">{{ $responden->desa_kelurahan }}</span><br>
                Kecamatan: <span class="dotted-line">{{ $responden->kecamatan }}</span><br>
                Kabupaten/Kota: <span class="dotted-line">{{ $responden->kabupaten_kota }}</span><br>
                Provinsi: <span class="dotted-line">{{ $responden->provinsi }}</span>
            </div>
        </div>
        
        <div class="question">
            <span class="question-num">5.</span>
            <span class="question-text">Tinggi Badan: <span class="dotted-line">{{ $responden->tinggi_badan }} Cm</span></span>
        </div>
        
        <div class="question">
            <span class="question-num">6.</span>
            <span class="question-text">Berat Badan: <span class="dotted-line">{{ $responden->berat_badan }} Kg</span></span>
        </div>
        
        <div class="question">
            <span class="question-num">7.</span>
            <span class="question-text">Pendidikan tertinggi</span>
            <div class="answer-row">
                @php
                    $pendidikan_options = ['sd' => 'SD', 'smp' => 'SMP', 'sma' => 'SMA', 'pt' => 'PT'];
                @endphp
                @foreach($pendidikan_options as $val => $label)
                    <div class="checkbox-item">
                        <span class="checkbox {{ $responden->pendidikan === $val ? 'checked' : '' }}">
                            {{ $responden->pendidikan === $val ? '✓' : '' }}
                        </span>
                        {{ $label }}
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="question">
            <span class="question-num">8.</span>
            <span class="question-text">Pekerjaan: <span class="dotted-line">{{ ucwords(str_replace('_', ' ', $responden->pekerjaan)) }}</span></span>
        </div>
        
        <div class="question">
            <span class="question-num">9.</span>
            <span class="question-text">Pendapatan rata-rata sebulan: <span class="dotted-line">{{ $responden->pendapatan }}</span></span>
        </div>
    </div>
    
    <!-- B. LITERASI FISIK -->
    <div class="section">
        <div class="section-title">B. LITERASI FISIK</div>
        
        <div class="question">
            <span class="question-num">1.</span>
            <span class="question-text">Berapa kali sekurang-kurangnya melakukan olahraga/aktivitas fisik dalam seminggu?</span>
            <div class="answer-row">
                @php $freq = (int)$responden->literasi_frekuensi; @endphp
                @for($i = 1; $i <= 4; $i++)
                    <div class="checkbox-item">
                        <span class="checkbox {{ $freq === $i ? 'checked' : '' }}">
                            {{ $freq === $i ? '✓' : $i }}
                        </span>
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="question">
            <span class="question-num">2.</span>
            <span class="question-text">Berapa menit minimal waktu dalam setiap kali melakukan olahraga/aktivitas fisik?</span>
            <div class="answer-row">
                @php
                    $durasi_map = ['10' => '10\'', '30' => '30\'', '45' => '45\'', '60' => '60\''];
                    $dur = $responden->literasi_durasi;
                @endphp
                @foreach($durasi_map as $val => $label)
                    <div class="checkbox-item">
                        <span class="checkbox {{ $dur === $val ? 'checked' : '' }}">
                            {{ $dur === $val ? '✓' : '' }}
                        </span>
                        {{ $label }}
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="question">
            <span class="question-num">3.</span>
            <span class="question-text">Bagaimana intensitas aktivitas olahraga/aktivitas fisik yang dilakukan?</span>
            <div class="answer-row">
                @php
                    $intensitas_map = ['ringan' => 'Ringan', 'sedang' => 'Sedang', 'cukup_berat' => 'Cukup berat', 'berat' => 'Berat'];
                    $int = $responden->literasi_intensitas;
                @endphp
                @foreach($intensitas_map as $val => $label)
                    <div class="checkbox-item">
                        <span class="checkbox {{ $int === $val ? 'checked' : '' }}">
                            {{ $int === $val ? '✓' : '' }}
                        </span>
                        {{ $label }}
                    </div>
                @endforeach
            </div>
        </div>
        
        @php $kesenangan = (int)$responden->literasi_kesenangan; @endphp
        <div class="question">
            <span class="question-num">4.</span>
            <span class="question-text">Sampai seberapa kesenangan Anda terhadap olahraga/aktivitas fisik?</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>senang</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $kesenangan === $i ? 'selected' : '' }}">{{ $kesenangan === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>senang</div>
                </div>
            </div>
        </div>
        
        @php $membaca = (int)$responden->literasi_membaca; @endphp
        <div class="question">
            <span class="question-num">5.</span>
            <span class="question-text">Apa Anda suka membaca buku/majalah/koran terkait olahraga?</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak suka</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $membaca === $i ? 'selected' : '' }}">{{ $membaca === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>suka</div>
                </div>
            </div>
        </div>
        
        @php $menonton = (int)$responden->literasi_menonton; @endphp
        <div class="question">
            <span class="question-num">6.</span>
            <span class="question-text">Apa Anda suka melihat pertandingan/kejuaraan olahraga?</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak suka</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $menonton === $i ? 'selected' : '' }}">{{ $menonton === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>suka</div>
                </div>
            </div>
        </div>
        
        @php $murah = (int)$responden->literasi_murah; @endphp
        <div class="question">
            <span class="question-num">7.</span>
            <span class="question-text">Olahraga merupakan cara murah dan mudah untuk menjaga kesehatan</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $murah === $i ? 'selected' : '' }}">{{ $murah === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- C. PARTISIPASI -->
    <div class="section">
        <div class="section-title">C. PARTISIPASI</div>
        
        <div class="question">
            <span class="question-num">1.</span>
            <span class="question-text">Apakah dalam satu minggu terakhir, Anda melakukan olahraga?</span>
            <div class="answer-row">
                <div class="checkbox-item">
                    <span class="checkbox {{ $responden->partisipasi_minggu_lalu === 'ya' ? 'checked' : '' }}">
                        {{ $responden->partisipasi_minggu_lalu === 'ya' ? '✓' : '' }}
                    </span>
                    Ya
                </div>
                <div class="checkbox-item">
                    <span class="checkbox {{ $responden->partisipasi_minggu_lalu === 'tidak' ? 'checked' : '' }}">
                        {{ $responden->partisipasi_minggu_lalu === 'tidak' ? '✓' : '' }}
                    </span>
                    Tidak
                </div>
            </div>
        </div>
        
        @if($responden->partisipasi_minggu_lalu === 'ya')
            <div class="question">
                <span class="question-num">2.</span>
                <span class="question-text">Berapa kali Anda berolahraga/melakukan aktivitas fisik dalam seminggu? {{ $responden->partisipasi_frekuensi ?? '-' }}</span>
            </div>
            
            <div class="question">
                <span class="question-num">3.</span>
                <span class="question-text">Berapa menit waktu yang Anda gunakan? {{ $responden->partisipasi_durasi ?? '-' }}</span>
            </div>
            
            <div class="question">
                <span class="question-num">4.</span>
                <span class="question-text">Jika diukur dengan skala 1-5, seberapa intens Anda melakukan olahraga? {{ $responden->partisipasi_intensitas ?? '-' }}</span>
            </div>
            
            <div class="question">
                <span class="question-num">5.</span>
                <span class="question-text">Jenis olahraga yang biasa dilakukan: {{ $responden->partisipasi_jenis ?? '-' }}</span>
            </div>
            
            <div class="question">
                <span class="question-num">6.</span>
                <span class="question-text">Tujuan utama Anda berolahraga: {{ $responden->partisipasi_tujuan ?? '-' }}</span>
            </div>
            
            <div class="question">
                <span class="question-num">7.</span>
                <span class="question-text">Tempat Anda melakukan olahraga: {{ $responden->partisipasi_tempat ?? '-' }}</span>
            </div>
        @else
            <div class="question">
                <span class="question-num">2-7.</span>
                <span class="question-text">[Tidak diisi - responden tidak melakukan olahraga minggu lalu]</span>
            </div>
        @endif
    </div>
    
    <!-- D. PERKEMBANGAN PERSONAL -->
    <div class="section">
        <div class="section-title">D. PERKEMBANGAN PERSONAL</div>
        
        @php $tantangan = (int)$responden->personal_tantangan; @endphp
        <div class="question">
            <span class="question-num">1.</span>
            <span class="question-text">Saya melihat kesulitan dalam hidup sebagai tantangan, bukan hambatan</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $tantangan === $i ? 'selected' : '' }}">{{ $tantangan === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
        
        @php $putus_asa = (int)$responden->personal_putus_asa; @endphp
        <div class="question">
            <span class="question-num">2.</span>
            <span class="question-text">Saya sering putus asa ketika menghadapi kesulitan</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $putus_asa === $i ? 'selected' : '' }}">{{ $putus_asa === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
        
        @php $solusi = (int)$responden->personal_solusi; @endphp
        <div class="question">
            <span class="question-num">3.</span>
            <span class="question-text">Saya terus berusaha mencari solusi meski sering juga gagal</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $solusi === $i ? 'selected' : '' }}">{{ $solusi === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
        
        @php $pertemuan = (int)$responden->personal_pertemuan; @endphp
        <div class="question">
            <span class="question-num">4.</span>
            <span class="question-text">Saya suka menghadiri pertemuan yang diadakan oleh warga sekitar</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $pertemuan === $i ? 'selected' : '' }}">{{ $pertemuan === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
        
        @php $curiga = (int)$responden->personal_curiga; @endphp
        <div class="question">
            <span class="question-num">5.</span>
            <span class="question-text">Saya sering curiga kepada orang lain yang sudah saya kenal</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $curiga === $i ? 'selected' : '' }}">{{ $curiga === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
        
        @php $percaya = (int)$responden->personal_percaya; @endphp
        <div class="question">
            <span class="question-num">6.</span>
            <span class="question-text">Saya lebih percaya kepada orang lain sesama etnis, agama, dan status sosial</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $percaya === $i ? 'selected' : '' }}">{{ $percaya === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- E. KESEHATAN -->
    <div class="section">
        <div class="section-title">E. KESEHATAN</div>
        
        @php $gangguan = (int)$responden->kesehatan_gangguan; @endphp
        <div class="question">
            <span class="question-num">1.</span>
            <span class="question-text">Seberapa sering Anda mengalami gangguan kesehatan/sakit?</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Tidak<br>pernah</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $gangguan === $i ? 'selected' : '' }}">{{ $gangguan === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>sering</div>
                </div>
            </div>
        </div>
        
        @php $puas = (int)$responden->kesehatan_puas; @endphp
        <div class="question">
            <span class="question-num">2.</span>
            <span class="question-text">Seberapa puas Anda dengan kesehatan Anda?</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak puas</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $puas === $i ? 'selected' : '' }}">{{ $puas === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>puas</div>
                </div>
            </div>
        </div>
        
        @php $kesiapan = (int)$responden->kesehatan_kesiapan; @endphp
        <div class="question">
            <span class="question-num">3.</span>
            <span class="question-text">Bagaimana kesiapan fisik Anda untuk melakukan aktivitas harian?</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak baik</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $kesiapan === $i ? 'selected' : '' }}">{{ $kesiapan === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>baik</div>
                </div>
            </div>
        </div>
        
        @php $yakin = (int)$responden->kesehatan_yakin; @endphp
        <div class="question">
            <span class="question-num">4.</span>
            <span class="question-text">Saya yakin terhadap apa yang saya lakukan meski tidak semua orang setuju</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $yakin === $i ? 'selected' : '' }}">{{ $yakin === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
        
        @php $karakter = (int)$responden->kesehatan_karakter; @endphp
        <div class="question">
            <span class="question-num">5.</span>
            <span class="question-text">Saya tidak menyukai karakter pribadi saya</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $karakter === $i ? 'selected' : '' }}">{{ $karakter === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
        
        @php $tujuan = (int)$responden->kesehatan_tujuan; @endphp
        <div class="question">
            <span class="question-num">6.</span>
            <span class="question-text">Banyak orang melakukan sesuatu tanpa tujuan yang jelas, tapi saya bukan bagian dari mereka</span>
            <div class="answer-row">
                <div style="display: flex; justify-content: space-between; width: 100%;">
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>tidak<br>setuju</div>
                    @for($i = 1; $i <= 5; $i++)
                        <div style="width: 16%; text-align: center;">
                            <div class="scale-box {{ $tujuan === $i ? 'selected' : '' }}">{{ $tujuan === $i ? '✓' : $i }}</div>
                        </div>
                    @endfor
                    <div style="font-size: 9pt; width: 10%; text-align: center;">Sangat<br>setuju</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- F. EKONOMI -->
    <div class="section">
        <div class="section-title">F. EKONOMI</div>
        
        <div class="question">
            <span class="question-num">1.</span>
            <span class="question-text">Apa Anda membelanjakan uang untuk membeli barang kebutuhan olahraga dan/atau menonton pertandingan/kejuaraan olahraga?</span>
            <div class="answer-row">
                <div class="checkbox-item">
                    <span class="checkbox {{ $responden->ekonomi_belanja === 'ya' ? 'checked' : '' }}">
                        {{ $responden->ekonomi_belanja === 'ya' ? '✓' : '' }}
                    </span>
                    Ya
                </div>
                <div class="checkbox-item">
                    <span class="checkbox {{ $responden->ekonomi_belanja === 'tidak' ? 'checked' : '' }}">
                        {{ $responden->ekonomi_belanja === 'tidak' ? '✓' : '' }}
                    </span>
                    Tidak
                </div>
            </div>
        </div>
        
        @if($responden->ekonomi_belanja === 'ya')
            <div class="question">
                <span class="question-num">2.</span>
                <span class="question-text">Berapa kira-kira jumlah uang yang Anda keluarkan untuk membeli barang kebutuhan olahraga selama setahun? {{ $responden->ekonomi_jumlah ?? '-' }}</span>
            </div>
            
            <div class="question">
                <span class="question-num">3.</span>
                <span class="question-text">Barang perlengkapan olahraga apa saja yang Anda beli? (Pilihan boleh lebih dari satu)</span>
                <div class="answer-row">
                    @php
                        $barang = $responden->ekonomi_barang;
                        if (is_string($barang)) {
                            $barang = json_decode($barang, true) ?? [];
                        }
                        $barang_labels = [
                            'sepatu' => 'Sepatu',
                            'pakaian' => 'Pakaian',
                            'peralatan' => 'Peralatan',
                            'aksesoris' => 'Aksesoris',
                            'makan_minum' => 'Biaya makan minum',
                            'suplemen' => 'Suplemen/Nutrisi',
                            'buku' => 'Buku/Majalah/Koran',
                            'cindera_mata' => 'Cindera mata'
                        ];
                    @endphp
                    @foreach($barang_labels as $val => $label)
                        <div class="checkbox-item">
                            <span class="checkbox {{ in_array($val, $barang ?? []) ? 'checked' : '' }}">
                                {{ in_array($val, $barang ?? []) ? '✓' : '' }}
                            </span>
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="question">
                <span class="question-num">4.</span>
                <span class="question-text">Jasa olahraga apa saja yang Anda bayar? (Pilihan boleh lebih dari satu)</span>
                <div class="answer-row">
                    @php
                        $jasa = $responden->ekonomi_jasa;
                        if (is_string($jasa)) {
                            $jasa = json_decode($jasa, true) ?? [];
                        }
                        $jasa_labels = [
                            'tiket' => 'Tiket pertandingan',
                            'tv_berbayar' => 'Langganan TV berbayar',
                            'pelatih' => 'Membayar pelatih',
                            'tempat_latihan' => 'Membayar tempat latihan',
                            'sewa_peralatan' => 'Sewa peralatan',
                            'perjalanan' => 'Biaya perjalanan',
                            'paramedik' => 'Jasa paramedik'
                        ];
                    @endphp
                    @foreach($jasa_labels as $val => $label)
                        <div class="checkbox-item">
                            <span class="checkbox {{ in_array($val, $jasa ?? []) ? 'checked' : '' }}">
                                {{ in_array($val, $jasa ?? []) ? '✓' : '' }}
                            </span>
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="question">
                <span class="question-num">2-4.</span>
                <span class="question-text">[Tidak diisi - responden tidak membelanjakan uang untuk kebutuhan olahraga]</span>
            </div>
        @endif
    </div>
    
    <!-- G. KEBUGARAN -->
    <div class="section">
        <div class="section-title">G. KEBUGARAN</div>
        
        <div class="question">
            <span class="question-num">1.</span>
            <span class="question-text">Level/Tingkat Kebugaran: <span class="dotted-line">{{ $responden->kebugaran_level ?? '-' }}</span></span>
        </div>
        
        <div class="question">
            <span class="question-num">2.</span>
            <span class="question-text">Balikan: <span class="dotted-line">{{ $responden->kebugaran_balikan ?? '-' }}</span></span>
        </div>
        
        <div class="question">
            <span class="question-num">3.</span>
            <span class="question-text">Vo2Max: <span class="dotted-line">{{ $responden->kebugaran_vo2max ?? '-' }}</span></span>
        </div>
    </div>
    
    <!-- SIGNATURE -->
    <div class="signature-section">
        <div class="section-title">PERNYATAAN & TANDA TANGAN</div>
        
        <div class="signature-box">
            <p>Saya telah mengisi angket ini secara jujur sesuai dengan kenyataan.</p>
            
            <table style="margin-top: 30px; border: none;">
                <tr>
                    <td width="50%"></td>
                    <td width="50%">
                        <p>{{ $responden->district?->city?->name ?? 'Lokasi' }}, {{ now()->format('d F Y') }}</p>
                        <p style="margin-top: 70px; border-top: 1px solid #000; padding-top: 10px;">
                            {{ $responden->nama }}
                        </p>
                        <p style="margin-top: 5px; font-size: 9pt; color: #666;">(Responden)</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="footer">
        Dokumen ini dicetak dari Sistem IPO Kalimantan Timur | Dicetak pada: {{ now()->format('d F Y H:i:s') }} WITA
    </div>

</body>
</html>

