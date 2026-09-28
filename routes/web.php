<?php

use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\AngketRespondenController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandingController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\IpoInfoController;
use App\Http\Controllers\SistemController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\CariController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DimensionController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->middleware('throttle:60,1')->group(function () {
    Route::get('/provinsi', [ApiController::class, 'provinsi']);
    Route::get('/ranking', [ApiController::class, 'ranking']);
    Route::get('/tren/{province}', [ApiController::class, 'tren'])->where('province', '[0-9]+');
});

// Public API untuk form register (no auth required)
Route::get('/api/districts', function (Illuminate\Http\Request $request) {
    $cityId = $request->query('city_id');
    if (!$cityId) {
        return response()->json(['error' => 'city_id required'], 422);
    }
    return \App\Models\District::where('city_id', $cityId)->orderBy('name')->select('id', 'name')->get();
});

Route::get('/api/city-from-district', function (Illuminate\Http\Request $request) {
    $districtId = $request->query('district_id');
    if (!$districtId) {
        return response()->json(['error' => 'district_id required'], 422);
    }
    $district = \App\Models\District::find($districtId);
    if (!$district) {
        return response()->json(['error' => 'District not found'], 404);
    }
    $city = \App\Models\City::find($district->city_id);
    return response()->json([
        'district_id' => $district->id,
        'district_name' => $district->name,
        'city_id' => $district->city_id,
        'city_name' => $city->name ?? null,
        'province_id' => $city->province_id ?? 1
    ]);
});

Route::get('/', fn() => redirect('/dashboard'));
Route::get('/api-dok', fn() => view('api.dok'));

Route::get('/bahasa/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'], true)) session(['locale' => $locale]);
    return back();
})->where('locale', '[a-z]+');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('throttle:10,1');
    Route::get('/lupa-password', [AuthController::class, 'lupa']);
    Route::post('/lupa-password', [AuthController::class, 'aturUlang'])->middleware('throttle:10,1');
    Route::get('/verifikasi-2fa', [AuthController::class, 'kode2fa']);
    Route::post('/verifikasi-2fa', [AuthController::class, 'cek2fa']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/sesi/perpanjang', [AuthController::class, 'perpanjang']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/profil/password', [ProfilController::class, 'password']);
    Route::post('/profil/password', [ProfilController::class, 'updatePassword']);
    Route::get('/profil/2fa/mulai', [ProfilController::class, 'mulai2fa']);
    Route::post('/profil/2fa/simpan', [ProfilController::class, 'simpan2fa']);
    Route::post('/profil/2fa/mati', [ProfilController::class, 'mati2fa']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/cari', [CariController::class, 'cari']);

    // Angket Responden
    // Operator: full CRUD (create, edit, delete)
    // Admin City & Superadmin: read-only (view, pdf)
    Route::middleware('auth')->prefix('data')->group(function () {
        Route::get('/', [AngketRespondenController::class, 'index'])->name('angket.index');
        Route::get('/{id}/pdf', [AngketRespondenController::class, 'exportPdf'])->name('angket.pdf')->where('id', '[0-9]+');
    });
    
    Route::middleware('operator')->prefix('data')->group(function () {
        Route::get('/tambah', [AngketRespondenController::class, 'create'])->name('angket.create');
        Route::post('/', [AngketRespondenController::class, 'store'])->name('angket.store');
        Route::get('/{id}/ubah', [AngketRespondenController::class, 'edit'])->name('angket.edit')->where('id', '[0-9]+');
        Route::put('/{id}', [AngketRespondenController::class, 'update'])->name('angket.update')->where('id', '[0-9]+');
        Route::delete('/{id}', [AngketRespondenController::class, 'destroy'])->name('angket.destroy')->where('id', '[0-9]+');
    });
    
    Route::get('/sampah', [SampahController::class, 'index'])->middleware('admin');
    Route::post('/sampah/{id}/pulih', [SampahController::class, 'pulih'])->middleware('admin')->where('id', '[0-9]+');
    Route::delete('/sampah/{id}', [SampahController::class, 'hapus'])->middleware('admin')->where('id', '[0-9]+');
    Route::post('/sampah/kosongkan', [SampahController::class, 'kosongkan'])->middleware('admin');

    Route::get('/hitung', [CalculateController::class, 'show']);
    
    // Hitung ulang untuk semua authenticated users (superadmin, admin_city, operator)
    Route::post('/hitung/ulang', [CalculateController::class, 'recalculate']);
    Route::get('/hitung/riwayat/{provinceId}', [CalculateController::class, 'history'])->where('provinceId', '[0-9]+');

    Route::get('/banding', [BandingController::class, 'index']);
    Route::get('/notifikasi', [NotifikasiController::class, 'index']);
    Route::post('/notifikasi/{id}/baca', [NotifikasiController::class, 'baca'])->where('id', '[0-9]+');
    Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'hapus'])->where('id', '[0-9]+');

    Route::get('/laporan', [ReportsController::class, 'index']);
    Route::get('/laporan/pdf', [ReportsController::class, 'pdf']);
    Route::get('/laporan/csv', [ReportsController::class, 'csv'])->middleware('throttle:60,1');
    Route::get('/laporan/xlsx', [ReportsController::class, 'xlsx'])->middleware('throttle:60,1');

    Route::middleware('superadmin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/aktivitas', [AktivitasController::class, 'index']);
        Route::get('/aktivitas/ekspor', [AktivitasController::class, 'ekspor']);
        Route::post('/aktivitas/bersih', [AktivitasController::class, 'bersih']);
        Route::get('/sistem', [SistemController::class, 'index']);
        Route::get('/sistem/backup', [SistemController::class, 'backup']);
        Route::post('/sistem/kunci/{year}', [SistemController::class, 'kunci'])->where('year', '[0-9]+');
        Route::post('/sistem/buka/{year}', [SistemController::class, 'buka'])->where('year', '[0-9]+');
        Route::post('/sistem/vakum', [SistemController::class, 'vakum']);
        Route::get('/users/tambah', [UserController::class, 'create']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{id}/ubah', [UserController::class, 'edit'])->where('id', '[0-9]+');
        Route::put('/users/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
        Route::post('/users/{id}/reset', [UserController::class, 'tokenReset'])->where('id', '[0-9]+');
        Route::post('/users/register-toggle', [UserController::class, 'toggleRegister']);
        Route::get('/users/ekspor', [UserController::class, 'ekspor']);

        // Bobot IPO (hanya superadmin)
        Route::get('/bobot', [BobotController::class, 'index']);
        Route::get('/bobot/create', [BobotController::class, 'create']);
        Route::post('/bobot', [BobotController::class, 'store']);
        Route::get('/bobot/{id}/edit', [BobotController::class, 'edit'])->where('id', '[0-9]+');
        Route::put('/bobot/{id}', [BobotController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/bobot/{id}', [BobotController::class, 'destroy'])->where('id', '[0-9]+');
    });

    Route::get('/bantuan', fn() => view('help'));
    Route::get('/api/options/{kind}', [DimensionController::class, 'options']);
    
    // Narasi/Penjelasan IPO (all authenticated users)
    Route::get('/tentang-ipo', [IpoInfoController::class, 'index'])->name('ipo.info');
});
