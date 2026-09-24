@extends('layouts.app')
@section('title', 'Pengaturan Bobot IPO — IPO')

@section('content')
<div class="anim-fade-up" style="display:flex;flex-direction:column;gap:14px">
  <div class="page-head">
    <div>
      <a href="/dashboard" style="font-size:12px;color:var(--ink-3)">← Kembali</a>
      <h1 style="font-size:18px;font-weight:600;color:var(--ink)">Pengaturan Bobot IPO</h1>
      <p style="font-size:12px;color:var(--ink-3);margin-top:4px">Kelola bobot untuk 6 dimensi angket responden per tahun</p>
    </div>
    <a href="/bobot/create" class="btn btn-primary btn-sm">+ Tambah Bobot Tahun Baru</a>
  </div>

  @if($bobots->count())
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Tahun</th>
          <th>Literasi Fisik</th>
          <th>Partisipasi</th>
          <th>Perkembangan Personal</th>
          <th>Kesehatan</th>
          <th>Ekonomi</th>
          <th>Kebugaran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($bobots as $bobot)
        <tr>
          <td><strong>{{ $bobot->year }}</strong></td>
          <td>÷ {{ number_format($bobot->literasi_fisik, 2) }}</td>
          <td>÷ {{ number_format($bobot->partisipasi, 2) }}</td>
          <td>÷ {{ number_format($bobot->perkembangan_personal, 2) }}</td>
          <td>÷ {{ number_format($bobot->kesehatan, 2) }}</td>
          <td>÷ {{ number_format($bobot->ekonomi, 2) }}</td>
          <td>÷ {{ number_format($bobot->kebugaran, 2) }}</td>
          <td style="text-align:right;gap:8px;display:flex">
            <a href="/bobot/{{ $bobot->id }}/edit" class="btn btn-secondary btn-sm" title="Edit">✏️</a>
            <form method="POST" action="/bobot/{{ $bobot->id }}" style="display:inline" onsubmit="return confirm('Hapus bobot tahun {{ $bobot->year }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" title="Hapus">🗑️</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <div class="card" style="padding:40px;text-align:center">
    <p style="color:var(--ink-3);font-size:14px">Belum ada pengaturan bobot. Buat bobot baru untuk tahun ini.</p>
    <a href="/bobot/create" class="btn btn-primary" style="margin-top:16px">Buat Bobot Tahun {{ date('Y') }}</a>
  </div>
  @endif
</div>
@endsection
