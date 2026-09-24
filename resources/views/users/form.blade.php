@extends('layouts.app')
@section('title', ($row ? 'Ubah' : 'Tambah') . ' User — IPO')

@section('content')
<div class="anim-fade-up" style="max-width:560px;display:flex;flex-direction:column;gap:14px">
  <div>
    <a href="/users" style="font-size:12px;color:var(--ink-3)">← Kembali</a>
    <h1 style="font-size:18px;font-weight:700;color:var(--ink)">{{ $row ? 'Ubah' : 'Tambah' }} User</h1>
  </div>
  <form method="POST" action="{{ $row ? "/users/{$row['id']}" : '/users' }}" class="card" style="padding:20px;display:flex;flex-direction:column;gap:14px">
    @csrf
    @if($row) @method('PUT') @endif
    <div class="input-group"><label for="u-name">Nama lengkap</label><input id="u-name" name="full_name" class="input" value="{{ old('full_name', $row['full_name'] ?? '') }}" required></div>
    <div class="input-group"><label for="u-user">Username</label><input id="u-user" name="username" class="input" value="{{ old('username', $row['username'] ?? '') }}" {{ $row ? 'disabled' : 'required' }}></div>
    <div class="input-group"><label for="u-pass">Password {{ $row ? '(kosongkan jika tidak diubah)' : '' }}</label><input id="u-pass" name="password" type="password" class="input" {{ $row ? '' : 'required' }}></div>
    <div class="input-group"><label for="u-role">Peran</label>
      <select id="u-role" name="role" class="input" required onchange="toggleScope()">
        @foreach($roles as $v => $l)
          <option value="{{ $v }}" {{ old('role', $row['role'] ?? 'operator') === $v ? 'selected' : '' }}>{{ $l }}</option>
        @endforeach
      </select>
    </div>
    <div class="input-group" id="city-group"><label for="u-city">Kabupaten/Kota</label>
      <select id="u-city" name="city_id" class="input" onchange="filterDistricts()">
        <option value="">Pilih Kota/Kab</option>
        @foreach($cities as $c)
          <option value="{{ $c->id }}" data-city="{{ $c->id }}" {{ (string) old('city_id', $row['city_id'] ?? '') === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="input-group" id="district-group"><label for="u-district">Kecamatan</label>
      <select id="u-district" name="district_id" class="input" onchange="autoFillCityFromDistrict()">
        <option value="">Pilih Kecamatan</option>
        @foreach($districts as $d)
          <option value="{{ $d->id }}" data-city="{{ $d->city_id }}" data-city-id="{{ $d->city_id }}" {{ (string) old('district_id', $row['district_id'] ?? '') === (string) $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
  </form>
  <div style="margin-top:8px">
    <div class="progress"><div id="pw-bar" data-w="0"></div></div>
    <div id="pw-teks" style="font-size:11.5px;color:var(--ink-3);margin-top:4px"></div>
  </div>
</div>

<script>
(function () {
  // Password strength meter
  var i = document.getElementById('u-pass');
  if (i) {
    i.addEventListener('input', function () {
      var v = i.value, s = 0;
      if (v.length > 5) { s = s + 1; }
      if (v.length > 9) { s = s + 1; }
      var campur = /[A-Z]/.test(v) && /[a-z]/.test(v);
      if (campur) { s = s + 1; }
      if (/\d/.test(v)) { s = s + 1; }
      var b = document.getElementById('pw-bar');
      b.style.width = (s * 20) + '%';
      b.className = s < 2 ? 'bar-red' : 'bar-green';
      document.getElementById('pw-teks').textContent = s < 2 ? 'Lemah' : 'Kuat';
    });
  }

  // Toggle scope fields based on role
  window.toggleScope = function() {
    var role = document.getElementById('u-role').value;
    var cityGroup = document.getElementById('city-group');
    var districtGroup = document.getElementById('district-group');
    
    if (role === 'superadmin') {
      cityGroup.style.display = 'none';
      districtGroup.style.display = 'none';
      document.getElementById('u-city').value = '';
      document.getElementById('u-district').value = '';
    } else if (role === 'admin_city') {
      cityGroup.style.display = 'flex';
      districtGroup.style.display = 'none';
      document.getElementById('u-district').value = '';
    } else {
      cityGroup.style.display = 'flex';
      districtGroup.style.display = 'flex';
    }
  };

  // Filter districts by city
  window.filterDistricts = function() {
    var cityId = document.getElementById('u-city').value;
    var districtSelect = document.getElementById('u-district');
    var options = districtSelect.querySelectorAll('option');
    
    options.forEach(function(opt) {
      if (opt.value === '') {
        opt.style.display = '';
      } else {
        opt.style.display = (opt.getAttribute('data-city') === cityId) ? '' : 'none';
      }
    });
    districtSelect.value = '';
  };

  // Auto-fill city when district is selected
  window.autoFillCityFromDistrict = function() {
    var districtSelect = document.getElementById('u-district');
    var selected = districtSelect.options[districtSelect.selectedIndex];
    
    if (selected && selected.value) {
      var cityId = selected.getAttribute('data-city');
      document.getElementById('u-city').value = cityId || '';
    }
  };

  // Init on load
  toggleScope();
  filterDistricts();
  autoFillCityFromDistrict();
})();
</script>
@endsection
