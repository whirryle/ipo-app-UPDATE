@extends('layouts.app')
@section('title', 'Tentang IPO — Indeks Pembangunan Olahraga')

@section('content')
<div class="anim-fade" style="display:flex;flex-direction:column;gap:20px;max-width:900px;margin:0 auto">
  
  <!-- Header -->
  <div class="card" style="padding:20px;background:linear-gradient(135deg, var(--brand-500), var(--brand-600));color:white">
    <div style="display:flex;align-items:center;gap:12px">
      <div style="font-size:28px">🏅</div>
      <div>
        <h1 style="font-size:24px;font-weight:800;margin:0">Indeks Pembangunan Olahraga (IPO)</h1>
        <p style="font-size:14px;margin:4px 0 0;opacity:0.9">Kalimantan Timur</p>
      </div>
    </div>
  </div>

  <!-- Tujuan -->
  <div class="card" style="padding:20px">
    <h2 style="font-size:16px;font-weight:700;margin:0 0 8px;color:var(--ink)">🎯 Tujuan</h2>
    <p style="font-size:14px;line-height:1.6;color:var(--ink-2);margin:0">
      {{ $ipoInfo['tujuan'] }}
    </p>
  </div>

  <!-- Fungsi -->
  <div class="card" style="padding:20px">
    <h2 style="font-size:16px;font-weight:700;margin:0 0 12px;color:var(--ink)">⚙️ Fungsi</h2>
    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px">
      @foreach($ipoInfo['fungsi'] as $f)
        <li style="font-size:14px;line-height:1.6;color:var(--ink-2);display:flex;gap:8px">
          <span style="flex-shrink:0;color:var(--brand-600)">✓</span>
          <span>{{ $f }}</span>
        </li>
      @endforeach
    </ul>
  </div>

  <!-- Konteks -->
  <div class="card" style="padding:20px;background:var(--brand-50);border-left:4px solid var(--brand-500)">
    <h2 style="font-size:14px;font-weight:700;margin:0 0 8px;color:var(--brand-700)">📋 Konteks</h2>
    <p style="font-size:14px;line-height:1.6;color:var(--brand-700);margin:0">
      {{ $ipoInfo['konteks'] }}
    </p>
  </div>

  <!-- 9 Dimensi -->
  <div style="border-top:1px solid var(--border);padding-top:20px">
    <h2 style="font-size:18px;font-weight:800;margin:0 0 16px;color:var(--ink)">📊 Sembilan Dimensi IPO</h2>
    
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:16px">
      @foreach($dimensi as $d)
        <div class="card" style="padding:16px">
          <div style="display:flex;align-items:start;gap:12px;margin-bottom:12px">
            <div style="font-weight:700;font-size:18px;color:var(--brand-600);min-width:36px">{{ $d['id'] }}</div>
            <div>
              <h3 style="font-size:14px;font-weight:700;margin:0;color:var(--ink)">{{ $d['nama'] }}</h3>
              <p style="font-size:12px;margin:2px 0 0;color:var(--ink-3);font-weight:500">Bobot: {{ $d['bobot'] }}%</p>
            </div>
          </div>
          
          <p style="font-size:13px;line-height:1.5;color:var(--ink-2);margin:0 0 8px">
            <strong>Deskripsi:</strong> {{ $d['deskripsi'] }}
          </p>
          
          <p style="font-size:13px;line-height:1.5;color:var(--ink-2);margin:0 0 8px">
            <strong>Indikator:</strong> {{ $d['indikator'] }}
          </p>
          
          <p style="font-size:13px;line-height:1.5;color:var(--ink-3);margin:0;padding:8px;background:var(--paper-2);border-radius:4px;border-left:3px solid var(--brand-400)">
            <strong>Konteks:</strong> {{ $d['konteks'] }}
          </p>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Metodologi -->
  <div style="border-top:1px solid var(--border);padding-top:20px">
    <h2 style="font-size:18px;font-weight:800;margin:0 0 16px;color:var(--ink)">🔬 Metodologi Perhitungan</h2>
    
    <div class="card" style="padding:16px;margin-bottom:16px">
      <p style="font-size:14px;line-height:1.6;color:var(--ink-2);margin:0">
        <strong>Perhitungan:</strong> {{ $metodologi['perhitungan'] }}
      </p>
    </div>

    <div class="card" style="padding:16px;margin-bottom:16px">
      <p style="font-size:14px;margin:0 0 12px;font-weight:600;color:var(--ink)">Skala Penilaian: {{ $metodologi['skala'] }}</p>
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));gap:8px">
        @foreach($metodologi['kategori'] as $kat)
          <div style="padding:12px;border-radius:6px;background:var(--{{ $kat['warna'] }}-50);border:1px solid var(--{{ $kat['warna'] }}-300)">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--{{ $kat['warna'] }}-700)">{{ $kat['range'] }}</div>
            <div style="font-size:13px;font-weight:600;color:var(--{{ $kat['warna'] }}-900);margin-top:2px">{{ $kat['label'] }}</div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="card" style="padding:16px;background:var(--info-50);border-left:4px solid var(--info-500)">
      <p style="font-size:14px;color:var(--info-700);margin:0">
        <strong>Update Data:</strong> {{ $metodologi['update'] }}
      </p>
    </div>
  </div>

  <!-- Info Tambahan -->
  <div class="card" style="padding:20px;background:var(--paper-2)">
    <h2 style="font-size:16px;font-weight:700;margin:0 0 12px;color:var(--ink)">💡 Catatan Penting</h2>
    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px;font-size:14px;color:var(--ink-2);line-height:1.6">
      <li style="display:flex;gap:8px">
        <span style="flex-shrink:0">•</span>
        <span>IPO adalah alat monitoring yang dinamis dan dapat disesuaikan bobot dimensinya sesuai prioritas kebijakan Pemerintah Daerah.</span>
      </li>
      <li style="display:flex;gap:8px">
        <span style="flex-shrink:0">•</span>
        <span>Data dikumpulkan secara bertingkat: operator kecamatan → admin kabupaten/kota → superadmin provinsi.</span>
      </li>
      <li style="display:flex;gap:8px">
        <span style="flex-shrink:0">•</span>
        <span>Transparansi data memastikan akuntabilitas dan pemberian dukungan yang tepat untuk pembangunan olahraga.</span>
      </li>
      <li style="display:flex;gap:8px">
        <span style="flex-shrink:0">•</span>
        <span>Untuk pertanyaan lebih lanjut, hubungi <strong>Dinas Kepemudaan dan Olahraga Provinsi Kalimantan Timur</strong>.</span>
      </li>
    </ul>
  </div>

  <!-- Back Button -->
  <div style="text-align:center;padding:16px">
    <a href="/dashboard" class="btn" style="background:var(--brand-500);color:white;text-decoration:none;padding:12px 24px;border-radius:6px;font-weight:600;display:inline-block">
      ← Kembali ke Dashboard
    </a>
  </div>

</div>

@media print {
  .no-print { display:none !important }
}
@endsection
