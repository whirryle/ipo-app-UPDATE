<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#5B21B6">
    <meta name="description" content="IPO — Indeks Pembangunan Olahraga. Data akurat, olahraga maju, masyarakat sehat!">
    <title>@yield('title', 'IPO — Indeks Pembangunan Olahraga')</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="stylesheet" href="/app.css">
    <script>try{if(localStorage.getItem('ipo-theme')==='dark'){document.documentElement.dataset.theme='dark';}}catch(e){}</script>
    <style>
        body { margin: 0; font-family: system-ui, -apple-system, sans-serif; background: #f5f3ff; }
        .guest-layout { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; }
        .guest-card { width: 100%; max-width: 500px; background: #fff; border-radius: 16px; box-shadow: 0 10px 40px rgba(91,33,182,.08); }
        .guest-header { background: linear-gradient(135deg, #2E1065 0%, #5B21B6 100%); color: #fff; padding: 32px 24px; text-align: center; border-radius: 16px 16px 0 0; }
        .guest-header h1 { margin: 0; font-size: 28px; font-weight: 800; }
        .guest-header p { margin: 8px 0 0; font-size: 14px; opacity: 0.9; }
        .guest-content { padding: 32px 24px; }
        .guest-footer { padding: 24px; text-align: center; font-size: 13px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .guest-footer a { color: #5B21B6; text-decoration: none; font-weight: 600; }
        .guest-footer a:hover { text-decoration: underline; }
        @media (max-width: 640px) {
            .guest-layout { padding: 12px; }
            .guest-header { padding: 24px 16px; }
            .guest-header h1 { font-size: 24px; }
            .guest-content { padding: 20px 16px; }
        }
    </style>
    @stack('head')
</head>
<body>
    <div class="guest-layout">
        <div class="guest-card">
            <div class="guest-header">
                <div style="width: 48px; height: 48px; background: #fff; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; font-weight: 800; color: #5B21B6; font-size: 20px;">IPO</div>
                <h1>@yield('guest_title', 'IPO')</h1>
                <p>@yield('guest_subtitle', 'Indeks Pembangunan Olahraga')</p>
            </div>
            <div class="guest-content">
                @if($errors->any())
                    <div style="background: #fee2e2; color: #991b1b; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px; font-size: 13px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
            <div class="guest-footer">
                @yield('guest_footer')
            </div>
        </div>
    </div>
    <script>
        function tukarTema() {
            const currentTheme = document.documentElement.dataset.theme || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.dataset.theme = newTheme;
            try { localStorage.setItem('ipo-theme', newTheme); } catch(e) {}
        }
    </script>
    @stack('scripts')
</body>
</html>
