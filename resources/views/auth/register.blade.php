<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#5B21B6">
    <title>Daftar — IPO</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    <link rel="stylesheet" href="/app.css">
    <style>
        .input-group {
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        margin 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        padding 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1;
            transform: translateY(0);
            max-height: 200px;
            overflow: hidden;
            margin-bottom: 0;
        }
        
        .input-group.hidden-field {
            opacity: 0;
            transform: translateY(-20px);
            max-height: 0;
            margin-bottom: -16px;
            pointer-events: none;
        }
    </style>
    <script>try{if(localStorage.getItem('ipo-theme')==='dark'){document.documentElement.dataset.theme='dark';}}catch(e){}</script>
</head>
<body>
<button type="button" onclick="tukarTema()" aria-label="Ganti tema gelap/terang" title="Gelap/Terang"
  style="position:fixed;top:14px;right:14px;z-index:60;width:40px;height:40px;border-radius:12px;border:1px solid rgba(255,255,255,.25);background:rgba(255,255,255,.12);color:#fff;font-size:18px;cursor:pointer">🌙</button>
<script>
function tukarTema(){var h=document.documentElement;var d=h.dataset.theme==='dark'?'light':'dark';h.dataset.theme=d;try{localStorage.setItem('ipo-theme',d);}catch(e){}var b=document.querySelector('button[onclick="tukarTema()"]');if(b)b.textContent=d==='dark'?'☀️':'🌙';}
(function(){try{if(localStorage.getItem('ipo-theme')==='dark'){var b=document.querySelector('button[onclick="tukarTema()"]');if(b)b.textContent='☀️';}}catch(e){}})();
</script>
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:16px;position:relative;overflow:hidden;background:linear-gradient(165deg,#2E1065 0%,#4C1D95 55%,#5B21B6 100%)">
  <div style="position:absolute;top:-96px;right:-96px;width:320px;height:320px;border-radius:50%;background:rgba(255,255,255,.05)"></div>
  <div style="position:absolute;bottom:-96px;left:-96px;width:320px;height:320px;border-radius:50%;background:rgba(255,255,255,.04)"></div>
  <div class="anim-fade-up" style="position:relative;width:100%;max-width:450px">
    <div style="text-align:center;margin-bottom:28px">
      <div style="display:flex;justify-content:center;margin-bottom:12px">
        <div style="width:72px;height:72px;border-radius:20px;background:#fff;color:var(--brand-700);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:24px">IPO</div>
      </div>
      <h1 style="color:#fff;font-size:26px;font-weight:800;letter-spacing:-.5px">IPO</h1>
      <p style="color:rgba(255,255,255,.8);font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.14em;margin-top:2px">Indeks Pembangunan Olahraga</p>
    </div>
    <div style="background:var(--white);border-radius:16px;padding:24px;box-shadow:0 20px 60px rgba(0,0,0,.3)">
      <h2 style="font-size:17px;font-weight:700;text-align:center;margin-bottom:4px;color:var(--ink)">{{ __('Buat Akun Baru') }}</h2>
      <p style="font-size:12px;text-align:center;margin-bottom:20px;color:var(--ink-3)">{{ __('Daftarkan diri Anda untuk mengakses sistem IPO') }}</p>
      @if($errors->any())
        <div role="alert" class="anim-fade" style="display:flex;gap:8px;font-size:12.5px;font-weight:500;padding:10px 14px;border-radius:12px;margin-bottom:16px;background:var(--red-100);color:var(--red)">{{ $errors->first() }}</div>
      @endif
      <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px">
        @csrf
        <div class="input-group">
          <label for="register-username">{{ __('Username') }}</label>
          <div style="position:relative">
            <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--ink-3)">👤</span>
            <input id="register-username" class="input" name="username" placeholder="{{ __('Masukkan username') }}" value="{{ old('username') }}" autofocus autocomplete="username" style="padding-left:40px">
          </div>
        </div>
        <div class="input-group">
          <label for="register-full-name">{{ __('Nama Lengkap') }}</label>
          <div style="position:relative">
            <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--ink-3)">👤</span>
            <input id="register-full-name" class="input" name="full_name" placeholder="{{ __('Nama lengkap Anda') }}" value="{{ old('full_name') }}" style="padding-left:40px">
          </div>
        </div>
        <div class="input-group">
          <label for="register-no-whatsapp">{{ __('No WhatsApp') }}</label>
          <div style="position:relative">
            <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--ink-3)">📱</span>
            <input id="register-no-whatsapp" class="input" name="no_whatsapp" placeholder="{{ __('08xxxxxxxxxx') }}" value="{{ old('no_whatsapp') }}" pattern="^08[0-9]{9,11}$" style="padding-left:40px">
            <p style="font-size:10px;color:var(--ink-3);margin-top:4px">Format: 08xxxxxxxxxx (10-13 digit)</p>
          </div>
        </div>
        <div class="input-group">
          <label for="register-password">{{ __('Password') }}</label>
          <div style="position:relative">
            <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--ink-3)">🔒</span>
            <input id="register-password" class="input" name="password" placeholder="{{ __('Masukkan password') }}" type="password" autocomplete="new-password" style="padding-left:40px">
            <p id="password-strength" style="font-size:10px;color:var(--ink-3);margin-top:4px"></p>
          </div>
        </div>
        <input type="hidden" name="role" value="operator">
        <div class="input-group">
          <label>{{ __('Role') }}</label>
          <div style="padding:12px 14px;background:var(--brand-50);border:1px solid var(--brand-100);border-radius:12px;color:var(--brand-700);font-size:13px;font-weight:500">
            ✓ Operator Kecamatan
          </div>
          <p style="font-size:10px;color:var(--ink-3);margin-top:4px">Pendaftaran publik hanya untuk Operator Kecamatan</p>
        </div>
        <div id="register-province-field" class="input-group hidden-field">
          <label for="register-province">{{ __('Provinsi') }}</label>
          <select id="register-province" name="province_id" class="input" style="padding-left:14px">
            <option value="1" selected>Kalimantan Timur</option>
          </select>
        </div>
        <div id="register-city-field" class="input-group hidden-field">
          <label for="register-city">{{ __('Kabupaten/Kota') }}</label>
          <select id="register-city" name="city_id" class="input" style="padding-left:14px">
            <option value="" disabled selected>{{ __('Pilih Kab/Kota') }}</option>
            @foreach(\App\Models\City::where('province_id', 1)->orderBy('name')->get() as $city)
              <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
          </select>
        </div>
        <div id="register-district-field" class="input-group hidden-field">
          <label for="register-district">{{ __('Kecamatan') }}</label>
          <select id="register-district" name="district_id" class="input" style="padding-left:14px">
            <option value="" disabled selected>{{ __('Pilih Kecamatan') }}</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="padding:12px;font-size:15px">{{ __('Daftar') }}</button>
      </form>
      <div style="text-align:center;margin-top:16px;font-size:12px;color:var(--ink-3)">
        {{ __('Sudah punya akun?') }} <a href="/login" style="color:var(--brand-600);font-weight:700">{{ __('Masuk') }}</a>
        <span style="margin:0 8px">·</span><a href="/bahasa/id" style="font-weight:700">ID</a> | <a href="/bahasa/en" style="font-weight:700">EN</a>
      </div>
    </div>
    <p style="text-align:center;color:rgba(255,255,255,.6);font-size:11px;margin-top:20px">© 2024–2026 IPO — Data Akurat, Olahraga Maju, Masyarakat Sehat!</p>
  </div>
</div>
<script>
(function(){
  const cityField = document.getElementById('register-city-field');
  const districtField = document.getElementById('register-district-field');
  const citySelect = document.getElementById('register-city');
  const districtSelect = document.getElementById('register-district');
  const passwordInput = document.getElementById('register-password');
  const passwordStrength = document.getElementById('password-strength');
  const provinceField = document.getElementById('register-province-field');

  // Role fixed to operator, always show all fields
  provinceField.classList.remove('hidden-field');
  cityField.classList.remove('hidden-field');
  districtField.classList.remove('hidden-field');

  citySelect.addEventListener('change', function() {
    const cityId = this.value;
    districtSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
    if (!cityId) return;
    fetch('/api/districts?city_id=' + cityId)
      .then(r => r.json())
      .then(data => {
        data.forEach(d => {
          const opt = document.createElement('option');
          opt.value = d.id;
          opt.textContent = d.name;
          districtSelect.appendChild(opt);
        });
      });
  });

  // Auto-fill Kab/Kota when Operator selects Kecamatan
  districtSelect.addEventListener('change', function() {
    const districtId = this.value;
    if (!districtId) return;
    fetch('/api/city-from-district?district_id=' + districtId)
      .then(r => r.json())
      .then(data => {
        if (data.city_id) {
          citySelect.value = data.city_id;
        }
      });
  });

  passwordInput.addEventListener('input', function(){
    const v=this.value; let s='Lemah';
    if(v.length>=12&&/[A-Z]/.test(v)&&/[0-9]/.test(v)&&/[^A-Za-z0-9]/.test(v)) s='Sangat Kuat';
    else if(v.length>=8&&/[A-Z]/.test(v)&&/[0-9]/.test(v)) s='Kuat';
    else if(v.length>=6) s='Sedang';
    passwordStrength.textContent=v?'Kekuatan: '+s:'';
  });
})();
</script>
</body>
</html>
