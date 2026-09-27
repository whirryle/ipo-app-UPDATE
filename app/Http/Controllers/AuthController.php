<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $cred = $request->validate(
                ['username' => 'required', 'password' => 'required'],
                ['username.required' => 'Username wajib diisi', 'password.required' => 'Password wajib diisi']
            );

            if (Auth::validate(['username' => $cred['username'], 'password' => $cred['password']])) {
                $row = DB::table('users')->where('username', $cred['username'])->first();
                if ($row && !empty($row->totp_aktif)) {
                    Cache::forget('gagal_' . strtolower($cred['username']));
                    $request->session()->put('tunggu_2fa', $row->id);
                    $request->session()->put('tunggu_2fa_ing', $request->boolean('remember'));
                    $request->session()->regenerate();
                    if ($request->expectsJson()) return response()->json(['perlu_2fa' => true], 202);
                    return redirect('/verifikasi-2fa');
                }
            }
            if (Auth::attempt(['username' => $cred['username'], 'password' => $cred['password']], $request->boolean('remember'))) {
                Cache::forget('gagal_' . strtolower($cred['username']));
                DB::table('login_logs')->insert(['username' => $cred['username'], 'ip' => $request->ip(), 'agen' => substr((string) $request->userAgent(), 0, 255), 'berhasil' => true]);
                $request->session()->put('sesi_mulai', time());
                $request->session()->regenerate();
                if ($request->expectsJson()) {
                    $u = $request->user()->load('province');
                    return response()->json(['user' => [
                        'id' => $u->id, 'username' => $u->username, 'full_name' => $u->full_name,
                        'role' => $u->role, 'province_id' => $u->province_id,
                        'province_name' => $u->province?->name,
                    ]]);
                }
                return redirect()->intended('/dashboard');
            }

            $kunci = 'gagal_' . strtolower($cred['username']);
            if (Cache::get($kunci, 0) >= 10) {
                $msg = 'Akun dikunci sementara karena terlalu banyak salah. Coba lagi 15 menit.';
                if ($request->expectsJson()) return response()->json(['error' => $msg], 423);
                return back()->withErrors(['username' => $msg])->onlyInput('username');
            }
            Cache::put($kunci, Cache::get($kunci, 0) + 1, 900);
            DB::table('login_logs')->insert(['username' => $cred['username'], 'ip' => $request->ip(), 'agen' => substr((string) $request->userAgent(), 0, 255), 'berhasil' => false]);
            if ($request->expectsJson()) return response()->json(['error' => __('Username atau password salah')], 401);
            return back()->withErrors(['username' => __('Username atau password salah')])->onlyInput('username');
        } catch (\Exception $e) {
            \Log::error('Error pada login', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'ip' => $request->ip(),
            ]);
            $msg = 'Terjadi kesalahan saat login. Silakan coba lagi nanti.';
            if ($request->expectsJson()) return response()->json(['error' => $msg], 500);
            return back()->withErrors(['error' => $msg])->onlyInput('username');
        }
    }

    public function lupa()
    {
        return view('auth.lupa');
    }

    public function aturUlang(Request $request)
    {
        try {
            $data = $request->validate([
                'token' => 'required', 'baru' => 'required|min:6',
            ]);
            $tok = DB::table('reset_tokens')->where('token', trim($data['token']))->first();
            if (!$tok || $tok->expires_at < date('Y-m-d H:i:s')) {
                return back()->withErrors(['token' => __('Token salah atau kedaluwarsa')])->withInput();
            }
            if ($tolak = \App\Support\PasswordKuat::cek($data['baru'])) {
                return back()->withErrors(['baru' => $tolak])->withInput();
            }
            DB::table('users')->where('id', $tok->user_id)->update(['password_hash' => Hash::make($data['baru'])]);
            DB::table('reset_tokens')->where('id', $tok->id)->delete();
            return redirect('/login')->with('toast', ['type' => 'success', 'text' => __('Password baru tersimpan. Silakan masuk.')]);
        } catch (\Exception $e) {
            Log::error('Error pada reset password', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'ip' => $request->ip(),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat reset password. Silakan coba lagi nanti.'])->withInput();
        }
    }

    public function kode2fa()
    {
        abort_unless(session()->has('tunggu_2fa'), 403, 'Tidak ada sesi verifikasi');
        return view('auth.kode2fa');
    }

    public function cek2fa(Request $request)
    {
        try {
            $uid = $request->session()->get('tunggu_2fa');
            abort_unless($uid, 403, 'Tidak ada sesi verifikasi');
            $row = DB::table('users')->where('id', $uid)->first();
            $kode = preg_replace('/\\D/', '', (string) $request->input('kode', ''));
            $ok = $row && !empty($row->totp_secret)
                && (new \PragmaRX\Google2FA\Google2FA)->verifyKey($row->totp_secret, $kode);
            if (!$ok) {
                return back()->withErrors(['kode' => __('Kode salah atau kedaluwarsa')]);
            }
            $request->session()->forget('tunggu_2fa');
            Auth::loginUsingId($uid, (bool) $request->session()->pull('tunggu_2fa_ing', false));
            DB::table('login_logs')->insert(['username' => $row->username, 'ip' => $request->ip(), 'agen' => substr((string) $request->userAgent(), 0, 255), 'berhasil' => true]);
            $request->session()->put('sesi_mulai', time());
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            Log::error('Error pada verifikasi 2FA', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'ip' => $request->ip(),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat verifikasi. Silakan coba lagi nanti.']);
        }
    }

    public function perpanjang(Request $request)
    {
        $request->session()->put('aktif', time());
        $request->session()->put('sesi_mulai', time());
        if ($request->expectsJson()) return response()->json(['message' => 'Sesi diperpanjang']);
        return back()->with('toast', ['type' => 'success', 'text' => __('Sesi diperpanjang.')]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegister()
    {
        if (\App\Support\Pengaturan::registerTutup()) {
            return view('auth.register_tutup');
        }
        return view('auth.register');
    }

    // Registrasi publik — user bisa pilih role sendiri
    public function register(Request $request)
    {
        if (\App\Support\Pengaturan::registerTutup()) {
            if ($request->expectsJson()) return response()->json(['error' => __('Pendaftaran ditutup sementara')], 403);
            abort(403, __('Pendaftaran ditutup sementara'));
        }
        
        $data = $request->validate(
            [
                'username' => 'required|min:3|max:50|unique:users,username',
                'password' => 'required|min:6',
                'full_name' => 'required|max:100',
                'no_whatsapp' => 'required|regex:/^08[0-9]{9,11}$/|unique:users,no_whatsapp',
                'province_id' => 'required|exists:provinces,id',
                'city_id' => 'required|exists:cities,id',
                'district_id' => 'required|exists:districts,id',
            ],
            [
                'username.required' => 'Username wajib diisi',
                'username.unique' => 'Username sudah digunakan',
                'password.required' => 'Password wajib diisi',
                'full_name.required' => 'Nama lengkap wajib diisi',
                'no_whatsapp.required' => 'No WhatsApp wajib diisi',
                'no_whatsapp.regex' => 'No WhatsApp harus format 08xxxxxxxxxx',
                'no_whatsapp.unique' => 'No WhatsApp sudah terdaftar',
                'province_id.required' => 'Provinsi wajib dipilih',
                'city_id.required' => 'Kab/Kota wajib dipilih',
                'district_id.required' => 'Kecamatan wajib dipilih',
            ]
        );

        if ($tolak = \App\Support\PasswordKuat::cek($data['password'])) {
            if ($request->expectsJson()) return response()->json(['error' => $tolak], 422);
            return back()->withErrors(['password' => $tolak])->withInput();
        }
        
        $user = User::create([
            'username' => $data['username'],
            'password_hash' => Hash::make($data['password']),
            'full_name' => $data['full_name'],
            'no_whatsapp' => $data['no_whatsapp'],
            'role' => 'operator', // HARDCODED: public registration selalu operator
            'province_id' => $data['province_id'],
            'city_id' => $data['city_id'] ?? null,
            'district_id' => $data['district_id'] ?? null,
        ]);

        if ($request->expectsJson()) return response()->json(['id' => $user->id, 'message' => __('Registrasi berhasil')], 201);
        return redirect('/login')->with('toast', ['type' => 'success', 'text' => __('Registrasi berhasil. Silakan masuk.')]);
    }

    public function me(Request $request)
    {
        $u = $request->user()->load('province');
        return response()->json(['user' => [
            'id' => $u->id, 'username' => $u->username, 'full_name' => $u->full_name,
            'role' => $u->role, 'province_id' => $u->province_id, 'province_name' => $u->province?->name,
        ]]);
    }
}
