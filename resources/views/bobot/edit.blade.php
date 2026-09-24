@extends('layouts.app')
@section('title', 'Edit Bobot IPO — IPO')

@section('content')
<div class="anim-fade-up" style="max-width:640px;display:flex;flex-direction:column;gap:14px">
  <div>
    <a href="/bobot" style="font-size:12px;color:var(--ink-3)">← Kembali</a>
    <h1 style="font-size:18px;font-weight:600;color:var(--ink)">Edit Bobot IPO Tahun {{ $bobot->year }}</h1>
    <p style="font-size:12px;color:var(--ink-3);margin-top:4px">Ubah bobot untuk 6 dimensi angket responden</p>
  </div>

  <form method="POST" action="/bobot/{{ $bobot->id }}" class="card" style="padding:20px;display:flex;flex-direction:column;gap:14px">
    @csrf
    @method('PUT')
    
    <div style="padding:14px;border-radius:10px;background:linear-gradient(135deg,#fef3c7 0%,#fde68a 100%);border-left:4px solid var(--warning,#d97706);font-size:13px;color:var(--ink-2)">
      <strong>⚠️ Perhatian:</strong> Perubahan bobot akan mempengaruhi perhitungan IPO untuk tahun {{ $bobot->year }} ke depannya.
    </div>

    <div class="input-group">
      <label>Tahun</label>
      <input type="text" class="input" value="{{ $bobot->year }}" disabled>
    </div>

    <div class="input-group">
      <label for="literasi_fisik">Literasi Fisik <span style="color:var(--danger)">*</span></label>
      <input id="literasi_fisik" name="literasi_fisik" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('literasi_fisik', $bobot->literasi_fisik) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 7</p>
    </div>

    <div class="input-group">
      <label for="partisipasi">Partisipasi <span style="color:var(--danger)">*</span></label>
      <input id="partisipasi" name="partisipasi" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('partisipasi', $bobot->partisipasi) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 7</p>
    </div>

    <div class="input-group">
      <label for="perkembangan_personal">Perkembangan Personal <span style="color:var(--danger)">*</span></label>
      <input id="perkembangan_personal" name="perkembangan_personal" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('perkembangan_personal', $bobot->perkembangan_personal) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 6</p>
    </div>

    <div class="input-group">
      <label for="kesehatan">Kesehatan <span style="color:var(--danger)">*</span></label>
      <input id="kesehatan" name="kesehatan" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('kesehatan', $bobot->kesehatan) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 6</p>
    </div>

    <div class="input-group">
      <label for="ekonomi">Ekonomi <span style="color:var(--danger)">*</span></label>
      <input id="ekonomi" name="ekonomi" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('ekonomi', $bobot->ekonomi) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 4</p>
    </div>

    <div class="input-group">
      <label for="kebugaran">Kebugaran <span style="color:var(--danger)">*</span></label>
      <input id="kebugaran" name="kebugaran" type="number" step="0.01" min="0.01" max="100" class="input" value="{{ old('kebugaran', $bobot->kebugaran) }}" required>
      <p style="font-size:11px;margin-top:4px;color:var(--ink-3)">Default: 3</p>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Perbarui Bobot</button>
  </form>
</div>
@endsection
