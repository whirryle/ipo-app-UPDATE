<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Superadmin yang dapat mengatur bobot');
        
        $bobots = Bobot::orderBy('year', 'desc')->get();
        $years = range(date('Y'), 2020);
        
        return view('bobot.index', compact('bobots', 'years'));
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Superadmin yang dapat mengatur bobot');
        
        $years = range(date('Y'), 2020);
        $existingYears = Bobot::pluck('year')->toArray();
        $availableYears = array_diff($years, $existingYears);
        
        return view('bobot.create', compact('availableYears'));
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Superadmin yang dapat mengatur bobot');
        
        $data = $request->validate([
            'year' => 'required|integer|unique:ipo_bobot,year',
            'literasi_fisik' => 'required|numeric|min:0.01|max:100',
            'partisipasi' => 'required|numeric|min:0.01|max:100',
            'perkembangan_personal' => 'required|numeric|min:0.01|max:100',
            'kesehatan' => 'required|numeric|min:0.01|max:100',
            'ekonomi' => 'required|numeric|min:0.01|max:100',
            'kebugaran' => 'required|numeric|min:0.01|max:100',
        ], [
            'year.required' => 'Tahun wajib dipilih',
            'year.unique' => 'Bobot untuk tahun ini sudah ada',
            '*.required' => 'Bobot wajib diisi',
            '*.numeric' => 'Bobot harus berupa angka',
            '*.min' => 'Bobot minimal 0.01',
            '*.max' => 'Bobot maksimal 100',
        ]);

        $data['user_id'] = $request->user()->id;

        Bobot::create($data);

        return redirect('/bobot')->with('toast', [
            'type' => 'success',
            'text' => 'Bobot berhasil ditambahkan untuk tahun ' . $data['year']
        ]);
    }

    public function edit(Request $request, $id)
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Superadmin yang dapat mengatur bobot');
        
        $bobot = Bobot::findOrFail($id);
        
        return view('bobot.edit', compact('bobot'));
    }

    public function update(Request $request, $id)
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Superadmin yang dapat mengatur bobot');
        
        $bobot = Bobot::findOrFail($id);

        $data = $request->validate([
            'literasi_fisik' => 'required|numeric|min:0.01|max:100',
            'partisipasi' => 'required|numeric|min:0.01|max:100',
            'perkembangan_personal' => 'required|numeric|min:0.01|max:100',
            'kesehatan' => 'required|numeric|min:0.01|max:100',
            'ekonomi' => 'required|numeric|min:0.01|max:100',
            'kebugaran' => 'required|numeric|min:0.01|max:100',
        ], [
            '*.required' => 'Bobot wajib diisi',
            '*.numeric' => 'Bobot harus berupa angka',
            '*.min' => 'Bobot minimal 0.01',
            '*.max' => 'Bobot maksimal 100',
        ]);

        $data['user_id'] = $request->user()->id;

        $bobot->update($data);

        return redirect('/bobot')->with('toast', [
            'type' => 'success',
            'text' => 'Bobot tahun ' . $bobot->year . ' berhasil diubah'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        abort_unless($request->user()->isSuperAdmin(), 403, 'Hanya Superadmin yang dapat mengatur bobot');
        
        $bobot = Bobot::findOrFail($id);
        $year = $bobot->year;
        $bobot->delete();

        return redirect('/bobot')->with('toast', [
            'type' => 'success',
            'text' => 'Bobot tahun ' . $year . ' berhasil dihapus'
        ]);
    }
}
