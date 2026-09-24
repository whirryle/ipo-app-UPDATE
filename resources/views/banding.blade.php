@extends('layouts.app')
@section('title', 'Banding Kabupaten/Kota — IPO')

@section('content')
<div class="anim-fade-up" style="display:flex;flex-direction:column;gap:14px">
  <div class="page-head">
    <div>
      <a href="/dashboard" style="font-size:12px;color:var(--ink-3)">← Kembali</a>
      <h1 style="font-size:18px;font-weight:600;color:var(--ink)">Banding Kabupaten/Kota</h1>
    </div>
    <form method="GET" action="/banding" class="toolbar no-print card" style="padding:12px">
      <select name="c[]" class="input" style="width:auto;max-width:200px" id="banding-city-1">
        <option value="">Pilih Kabupaten/Kota 1</option>
        @foreach($cities as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>
      <select name="c[]" class="input" style="width:auto;max-width:200px" id="banding-city-2">
        <option value="">Pilih Kabupaten/Kota 2</option>
        @foreach($cities as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>
      <select name="c[]" class="input" style="width:auto;max-width:200px" id="banding-city-3">
        <option value="">Pilih Kabupaten/Kota 3</option>
        @foreach($cities as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>
      <select name="year" class="input" style="width:auto">
        @foreach($years as $y)<option value="{{ $y }}" {{ (int)$year === (int)$y ? 'selected' : '' }}>{{ $y }}</option>@endforeach
      </select>
      <button class="btn btn-primary btn-sm" type="submit">Bandingkan</button>
    </form>
    <div class="no-print" style="display:flex;gap:8px">
      <a class="btn btn-secondary btn-sm" href="/banding?c[]={{ implode('&c[]=', $pilih) }}&year={{ $year }}&ekspor=pdf">Ekspor PDF</a>
    </div>
  </div>
  @if(count($dims))
  <div class="card" style="padding:20px">
    <div style="height:280px"><canvas id="bandingChart"></canvas></div>
  </div>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Dimensi</th>@foreach($dims as $d)<th>{{ $d['nama'] }}</th>@endforeach</tr></thead>
      <tbody>gi 
        @foreach($labels as $k => $label)
          <tr><td><b>{{ $label }}</b></td>@foreach($dims as $d)<td>{{ $d['skor'][$k] }}</td>@endforeach</tr>
        @endforeach
        <tr><td><b>IPO</b></td>@foreach($dims as $d)<td style="font-weight:800;color:var(--brand-700)">{{ $d['ipo'] }}</td>@endforeach</tr>
      </tbody>
    </table>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script src="/vendor/chart.umd.js"></script>
<script type="application/json" id="banding-data">@json($dims)</script>
<script>
// Prevent duplicate city selection
(function () {
  var selects = [
    document.getElementById('banding-city-1'),
    document.getElementById('banding-city-2'),
    document.getElementById('banding-city-3')
  ];
  
  function updateDisabledOptions() {
    var selected = selects.map(function(s) { return s ? s.value : ''; }).filter(Boolean);
    
    selects.forEach(function(select) {
      if (!select) return;
      var currentValue = select.value;
      
      Array.from(select.options).forEach(function(option) {
        if (!option.value) {
          option.disabled = false;
          return;
        }
        
        if (selected.indexOf(option.value) !== -1 && option.value !== currentValue) {
          option.disabled = true;
        } else {
          option.disabled = false;
        }
      });
    });
  }
  
  selects.forEach(function(select) {
    if (select) {
      select.addEventListener('change', updateDisabledOptions);
    }
  });
  
  updateDisabledOptions();
})();

(function () {
  var cv = document.getElementById('bandingChart');
  if (!cv) return;
  var rows = JSON.parse(document.getElementById('banding-data').textContent);
  var dark = document.documentElement.dataset.theme === 'dark';
  var tick = dark ? '#C9C5DE' : '#4B5563';
  var chart = new Chart(cv, { type: 'bar',
    data: { labels: rows.map(function (r) { return r.nama; }),
      datasets: [{ label: 'IPO {{ $year }}', data: rows.map(function (r) { return r.ipo; }),
        backgroundColor: '#6D28D9', borderRadius: 8 }]},
    options: { responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { x: { ticks: { color: tick, font: { size: 10 } } },
        y: { min: 0, max: 100, ticks: { color: tick, stepSize: 25 } } } } });
  window.refreshChartTheme = function () {
    var dk = document.documentElement.dataset.theme === 'dark';
    var tk = dk ? '#C9C5DE' : '#4B5563';
    chart.options.scales.x.ticks.color = tk;
    chart.options.scales.y.ticks.color = tk;
    chart.update();
  };
})();
</script>
@endpush