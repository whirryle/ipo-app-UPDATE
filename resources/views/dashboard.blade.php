@extends('layouts.app')
@section('title', 'Dashboard — IPO')

@section('content')
@php
  $u = auth()->user();
  $roleLabel = $u->role === 'admin' && $u->province_id === null ? 'Administrator' : ($u->role === 'operator' ? 'Operator' : ($u->role === 'admin' ? 'Admin' : 'User'));
  $katClass = ['Baik' => 'badge-baik', 'Cukup' => 'badge-cukup', 'Kurang' => 'badge-kurang', 'Sangat Kurang' => 'badge-sangat-kurang'][$kategori] ?? 'badge-neutral';
  $scorePercent = min(max($score, 0), 100);
  $circ = 2 * pi() * 74;
  $off = $circ * (1 - $scorePercent / 100);
@endphp

<!-- BENTO GRID DASHBOARD (DESIGN.md Fase 3) -->
<div class="grid-bento stagger" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px">
  
  <!-- HERO PANEL (large 2x2) -->
  <div class="card" style="padding:24px;grid-column:span 2" id="hero-panel">
    <div style="position:relative;min-height:180px;border-radius:16px;overflow:hidden;background:linear-gradient(135deg,rgba(46,16,101,.05) 0%,rgba(255,255,255,0) 100%)">
      <div style="display:flex;justify-content:space-between;position:relative;z-index:10">
        <div>
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--ink-3)">IPO Provinsi</div>
          <h1 style="font-size:26px;font-weight:800;margin-top:4px;color:var(--ink)">{{ $provinceName }}</h1>
          <div style="display:flex;gap:8px;margin-top:8px;flex-wrap:wrap">
            <span class="badge badge-blue">{{ $roleLabel }}</span>
            @if($u->province?->name)<span class="badge badge-neutral">📍 {{ $u->province->name }}</span>@endif
            <span class="badge" style="background:var(--brand-100);color:var(--brand-700)">Tahun {{ $year }}</span>
          </div>
        </div>
        <div style="text-align:right">
          <div style="font-size:12px;font-weight:600;color:var(--ink-3)">Skor {{ $year }}</div>
          <div id="score-display" style="font-size:36px;font-weight:800;color:var(--brand-500)">{{ number_format($score, 2, ',', '.') }}</div>
          <div style="font-size:12px;color:var(--ink-3)">/100</div>
        </div>
      </div>
      <!-- Score Ring Overlay -->
      <svg width="120" height="120" viewBox="0 0 170 170" style="position:absolute;bottom:16px;right:16px">
        <circle cx="85" cy="85" r="74" fill="none" stroke="var(--ring-track)" stroke-width="12" opacity="0.3"/>
        <circle cx="85" cy="85" r="74" fill="none" stroke="var(--brand-500)" stroke-width="12" stroke-linecap="round" stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $off }}" transform="rotate(-90 85 85)" class="ring-fill"/>
      </svg>
    </div>
  </div>

  <!-- STATS CARDS (3 small) -->
  <div class="card" style="padding:16px">
    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--ink-3)">Total Data</div>
    <div style="font-size:24px;font-weight:800;color:var(--ink);font-variant-numeric:tabular-nums">{{ number_format($totalRecords, 0) }}</div>
  </div>
  
  <div class="card" style="padding:16px">
    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--ink-3)">Dimensi</div>
    <div style="font-size:24px;font-weight:800;color:var(--ink);font-variant-numeric:tabular-nums">{{ count($dimensions) }}</div>
  </div>
  
  <div class="card" style="padding:16px">
    <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--ink-3)">Tahun Tren</div>
    <div style="font-size:24px;font-weight:800;color:var(--ink);font-variant-numeric:tabular-nums">{{ count($trend) }}</div>
  </div>

  <!-- TREN CHART (medium 2x1) -->
  <div class="card" style="padding:20px;grid-column:span 2">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
      <h3 style="font-size:15px;font-weight:700;color:var(--ink)">Perkembangan 5 Tahun</h3>
      <a href="/grafik" style="font-size:12.5px;font-weight:600;color:var(--brand-600)">Grafik →</a>
    </div>
    <div style="height:220px">
      <canvas id="trenChart" data-tren="{{ json_encode($trend) }}"></canvas>
    </div>
  </div>

  <!-- RINGKASAN NASIONAL (medium 1x1) -->
  @if(!empty($nasional))
  <div class="card" style="padding:16px">
    <div style="display:flex;align-items:center;justify-content:space-between">
      <div>
        <div style="font-size:11px;text-transform:uppercase;color:var(--ink-3)">Rata-rata Nasional {{ $year }}</div>
        <div style="font-size:22px;font-weight:800;color:var(--brand-500)">{{ number_format($nasional['rata'], 2, ',', '.') }}</div>
      </div>
      <div style="text-align:right">
        @if(!empty($nasional['peringkat']))
        <div style="font-size:12px;color:var(--ink-2)">Provinsi Anda</div>
        <div style="font-size:18px;font-weight:800;color:var(--brand-500)">#{{ $nasional['peringkat'] }}</div>
        @endif
      </div>
    </div>
    <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
      <div style="font-size:11px;font-weight:700;color:var(--green)">▲ {{ __('3 Teratas') }}</div>
      @foreach($nasional['atas'] as $t)
        <div style="font-size:12px;margin-top:4px">{{ $t->name }} · <b style="color:var(--ink)">{{ number_format($t->ipo_score * 100, 1, ',', '.') }}</b></div>
      @endforeach
    </div>
    <div style="margin-top:12px">
      <div style="font-size:11px;font-weight:700;color:var(--red)">▼ {{ __('3 Terbawah') }}</div>
      @foreach($nasional['bawah'] as $t)
        <div style="font-size:12px;margin-top:4px">{{ $t->name }} · <b style="color:var(--ink)">{{ number_format($t->ipo_score * 100, 1, ',', '.') }}</b></div>
      @endforeach
    </div>
  </div>
  @endif

  <!-- 9 DIMENSI (wide 3x1) -->
  <div class="card" style="padding:16px;grid-column:span 3">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
      <h3 style="font-size:15px;font-weight:700;color:var(--ink)">9 Dimensi IPO</h3>
      <a href="/hitung?year={{ $year }}" style="font-size:12.5px;font-weight:600;color:var(--brand-600)">Perhitungan →</a>
    </div>
    <div style="display:flex;flex-direction:column;gap:8px">
      @foreach($dimensions as $d)
        @php
          $display = $d['display'];
          $width = max(5, min(100, $display));
          $barColor = $display >= 51 ? 'var(--brand-500)' : 'var(--red)';
        @endphp
        <div style="display:flex;align-items:center;gap:10px">
          <div style="font-size:12.5px;font-weight:600;color:var(--ink);min-width:110px">{{ $d['label'] }}</div>
          <div class="progress" style="flex:1;max-width:200px;height:6px;background:var(--ring-track)">
            <div style="width:{{ $width }}%;height:100%;background:{{ $barColor }};border-radius:99px"></div>
          </div>
          <div style="font-size:12px;color:var(--ink-3);min-width:36px;text-align:right">{{ $display }}%</div>
        </div>
      @endforeach
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
(function() {
  var ctx = document.getElementById('trenChart');
  if (!ctx) return;
  
  var trenData = {!! json_encode($trend) !!};
  var labels = trenData.map(function(t) { return t.year; });
  var scores = trenData.map(function(t) { return Math.round(t.ipo_score * 100); });
  
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'IPO',
        data: scores,
        borderColor: '#7C3AED',
        backgroundColor: 'rgba(124,58,237,0.1)',
        borderWidth: 2.5,
        pointRadius: 5,
        pointBackgroundColor: '#7C3AED',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { mode: 'index', intersect: false }
      },
      scales: {
        y: { 
          min: 0, 
          max: 100, 
          grid: { color: '#E7E5EF' }, 
          ticks: { color: '#7A7790', callback: function(v) { return v + '%'; } } 
        },
        x: { 
          grid: { display: false }, 
          ticks: { color: '#7A7790' } 
        }
      }
    }
  });
})();
</script>
@endpush
