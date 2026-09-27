<?php

namespace App\Http\Controllers;

use App\Models\AngketResponden;
use App\Models\District;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class AngketRespondenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $year = date('Y');
        
        // Role-based data scope
        $query = AngketResponden::where('year', $year);
        
        if ($user->isSuperAdmin()) {
            // Superadmin: all data in province
            $query->where('province_id', $user->province_id);
        } elseif ($user->isAdminCity()) {
            // Admin City: all districts in their city
            $query->where('city_id', $user->city_id);
        } else {
            // Operator: only their district
            $query->where('operator_id', $user->id)
                  ->where('district_id', $user->district_id);
        }
        
        $query->orderBy('created_at', 'desc');
        $responden = $query->paginate(20);
        
        // Count submitted responden (for operator only)
        $count = 0;
        $canAdd = false;
        if ($user->isOperator()) {
            $count = AngketResponden::countResponden($user->district_id, $year);
            $canAdd = AngketResponden::canAddResponden($user->district_id, $year);
        }
        
        return view('angket.index', compact('responden', 'count', 'canAdd', 'year'));
    }

    public function create()
    {
        $user = Auth::user();
        $year = date('Y');
        
        // Check if can add more responden
        if (!AngketResponden::canAddResponden($user->district_id, $year)) {
            return redirect()->route('angket.index')
                ->with('error', 'Maksimal 30 responden per kecamatan per tahun telah tercapai');
        }
        
        $responden = null;
        return view('angket.wizard', compact('responden'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $year = date('Y');
            
            // Validate based on current step
            $step = $request->input('step', 1);
            
            $validated = $this->validateStep($request, $step);
            
            // Check if updating existing draft or creating new
            $respondenId = $request->input('responden_id');
            
            if ($respondenId) {
                $responden = AngketResponden::findOrFail($respondenId);
                
                // Security: operator can only edit their own responden
                if ($responden->operator_id !== $user->id) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
                
                $responden->update($validated);
            } else {
                // Create new draft
                $validated['operator_id'] = $user->id;
                $validated['district_id'] = $user->district_id;
                $validated['city_id'] = $user->city_id;
                $validated['province_id'] = 1; // Kaltim
                $validated['year'] = $year;
                $validated['status'] = 'draft';
                
                $responden = AngketResponden::create($validated);
            }
            
            return response()->json([
                'success' => true,
                'responden_id' => $responden->id,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error pada store angket', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
                'step' => $request->input('step', 1),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $responden = AngketResponden::findOrFail($id);
        
        // Security: operator can only edit their own responden
        if ($responden->operator_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        
        return view('angket.wizard', compact('responden'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $responden = AngketResponden::findOrFail($id);
            
            // Security check
            if ($responden->operator_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            
            $step = $request->input('step', 1);
            $validated = $this->validateStep($request, $step);
            
            $responden->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            Log::error('Error pada update angket', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
                'responden_id' => $id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat update data. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $responden = AngketResponden::findOrFail($id);
        
        // Security check
        if ($responden->operator_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        
        $responden->delete();
        
        return redirect()->route('angket.index')
            ->with('success', 'Responden berhasil dihapus');
    }

    public function exportPdf($id)
    {
        $user = Auth::user();
        $responden = AngketResponden::findOrFail($id);
        
        // Security check: role-based access
        if ($user->isOperator()) {
            // Operator: only their own responden
            if ($responden->operator_id !== $user->id) {
                abort(403, 'Unauthorized');
            }
        } elseif ($user->isAdminCity()) {
            // Admin City: only responden in their city
            if ($responden->city_id !== $user->city_id) {
                abort(403, 'Unauthorized');
            }
        } elseif ($user->isSuperAdmin()) {
            // Superadmin: only responden in their province
            if ($responden->province_id !== $user->province_id) {
                abort(403, 'Unauthorized');
            }
        } else {
            abort(403, 'Unauthorized');
        }
        
        $pdf = Pdf::loadView('angket.pdf.responden', compact('responden'))
            ->setPaper('a4', 'portrait');
        
        $filename = 'Angket_' . str_replace(' ', '_', $responden->nama) . '_' . date('Ymd') . '.pdf';
        
        return $pdf->download($filename);
    }

    private function validateStep(Request $request, int $step): array
    {
        $rules = [];
        
        switch ($step) {
            case 1: // A. Identitas
                $rules = [
                    'nama' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:pria,wanita',
                    'tanggal_lahir' => 'required|date',
                    'desa_kelurahan' => 'required|string|max:255',
                    'kecamatan' => 'required|string|max:255',
                    'kabupaten_kota' => 'required|string|max:255',
                    'provinsi' => 'required|string|max:255',
                    'tinggi_badan' => 'required|integer|min:50|max:250',
                    'berat_badan' => 'required|numeric|min:10|max:300',
                    'pendidikan' => 'required|in:sd,smp,sma,pt',
                    'pekerjaan' => 'required|in:pns,mhs_pelajar,petani,tni_polri,pedagang,wirausaha,karyawan,lainnya',
                    'pendapatan' => 'required|in:0,<2juta,2-5juta,5-9juta,9-14juta,14-20juta,>20juta',
                ];
                break;
                
            case 2: // B. Literasi Fisik
                $rules = [
                    'literasi_frekuensi' => 'required|in:1,2,3,4',
                    'literasi_durasi' => 'required|in:10,30,45,60',
                    'literasi_intensitas' => 'required|in:ringan,sedang,cukup_berat,berat',
                    'literasi_kesenangan' => 'required|integer|min:1|max:5',
                    'literasi_membaca' => 'required|integer|min:1|max:5',
                    'literasi_menonton' => 'required|integer|min:1|max:5',
                    'literasi_murah' => 'required|integer|min:1|max:5',
                ];
                break;
                
            case 3: // C. Partisipasi
                $rules = [
                    'partisipasi_minggu_lalu' => 'required|in:ya,tidak',
                    'partisipasi_frekuensi' => 'nullable|in:1,2,3,4,5+',
                    'partisipasi_durasi' => 'nullable|in:0-20,21-30,31-45,46-60,60+',
                    'partisipasi_intensitas' => 'nullable|integer|min:1|max:5',
                    'partisipasi_jenis' => 'nullable|string|max:100',
                    'partisipasi_tujuan' => 'nullable|string|max:100',
                    'partisipasi_tempat' => 'nullable|string|max:100',
                ];
                break;
                
            case 4: // D. Perkembangan Personal
                $rules = [
                    'personal_tantangan' => 'required|integer|min:1|max:5',
                    'personal_putus_asa' => 'required|integer|min:1|max:5',
                    'personal_solusi' => 'required|integer|min:1|max:5',
                    'personal_pertemuan' => 'required|integer|min:1|max:5',
                    'personal_curiga' => 'required|integer|min:1|max:5',
                    'personal_percaya' => 'required|integer|min:1|max:5',
                ];
                break;
                
            case 5: // E. Kesehatan
                $rules = [
                    'kesehatan_gangguan' => 'required|integer|min:1|max:5',
                    'kesehatan_puas' => 'required|integer|min:1|max:5',
                    'kesehatan_kesiapan' => 'required|integer|min:1|max:5',
                    'kesehatan_yakin' => 'required|integer|min:1|max:5',
                    'kesehatan_karakter' => 'required|integer|min:1|max:5',
                    'kesehatan_tujuan' => 'required|integer|min:1|max:5',
                ];
                break;
                
            case 6: // F. Ekonomi
                $rules = [
                    'ekonomi_belanja' => 'required|in:ya,tidak',
                    'ekonomi_budget' => 'nullable|string|max:50',
                    'ekonomi_barang_dibeli' => 'nullable|array',
                    'ekonomi_jasa_dibayar' => 'nullable|array',
                ];
                break;
                
            case 7: // G. Kebugaran
                $rules = [
                    'kebugaran_level' => 'nullable|string|max:100',
                    'kebugaran_balikan' => 'nullable|string|max:100',
                    'kebugaran_vo2max' => 'nullable|string|max:100',
                ];
                break;
                
            case 8: // Final submit
                $rules = ['status' => 'required|in:submitted'];
                break;
        }
        
        return $request->validate($rules);
    }
}
