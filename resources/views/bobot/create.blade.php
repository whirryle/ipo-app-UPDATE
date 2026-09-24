@extends('layouts.app')
@section('title', 'Tambah Bobot IPO — IPO')

@section('content')
<div class="anim-fade-up" style="max-width:640px;display:flex;flex-direction:column;gap:14px">
  <div>
    <a href="/bobot" style="font-size:12px;color:var(--ink-3)">← Kembali</a>
    <h1 style="font-size:18px;font-weight:600;color:var(--ink)">Tambah Bobot IPO</h1>
    <p style="font-size:12px;color:var(--ink-3);margin-top:4px">Atur bobot untuk 6 dimensi angket responden</p>
  </div>

  <form method="POST" action="/bobot" class="card" style="padding:20px;display:flex;flex-direction:column;gap:14px">
    @csrf
    
    <div class="input-group">
      <label for="year">Tahun <span style="color:var(--danger)">*</span></label>
      <select id="year" name="year" class="input" required>
        <option value="">Pilih tahun</option>
        @foreach($availableYears as $y)
        <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endforeach
      </select>
    </div>

    <div style="padding:14px;border-radius:10px;background:linear-gradient(135deg,#f0f9ff 0%,#e0f2fe 100%);border-left:4px solid var(--brand-700,#5B21B6);font-size:13px;color:var(--ink-2)">
      <strong>ℹ️ Informasi:</strong> Bobot ini digunakan sebagai pembagi dimensi. Default = jumlah pertanyaan kuesioner.
    </div>

    <div class="input-group">
      <label for="literasi_fisik">Literasi Fisik <span style="color:var(--danger)">*</span></label>
      <input id="literasi_fisik" name="literasi_fisik" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('literasi_fisik', 7) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 7 (jumlah pertanyaan kuesioner)</p>
    </div>

    <div class="input-group">
      <label for="partisipasi">Partisipasi <span style="color:var(--danger)">*</span></label>
      <input id="partisipasi" name="partisipasi" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('partisipasi', 7) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 7 (jumlah pertanyaan kuesioner)</p>
    </div>

    <div class="input-group">
      <label for="perkembangan_personal">Perkembangan Personal <span style="color:var(--danger)">*</span></label>
      <input id="perkembangan_personal" name="perkembangan_personal" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('perkembangan_personal', 6) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 6 (jumlah pertanyaan kuesioner)</p>
    </div>

    <div class="input-group">
      <label for="kesehatan">Kesehatan <span style="color:var(--danger)">*</span></label>
      <input id="kesehatan" name="kesehatan" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('kesehatan', 6) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 6 (jumlah pertanyaan kuesioner)</p>
    </div>

    <div class="input-group">
      <label for="ekonomi">Ekonomi <span style="color:var(--danger)">*</span></label>
      <input id="ekonomi" name="ekonomi" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('ekonomi', 4) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 4 (jumlah pertanyaan kuesioner)</p>
    </div>

    <div class="input-group">
      <label for="kebugaran">Kebugaran <span style="color:var(--danger)">*</span></label>
      <input id="kebugaran" name="kebugaran" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('kebugaran', 3) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 3 (jumlah pertanyaan kuesioner)</p>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Simpan Bobot</button>
  </form>
</div>
@endsection
