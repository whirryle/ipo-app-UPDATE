@extends('layouts.app')

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding: 24px 16px;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 28px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 280px;">
            <h1 style="font-size: 24px; font-weight: 700; color: var(--ink); margin-bottom: 6px;">Angket Responden</h1>
            <p style="font-size: 13px; color: var(--ink-3); margin: 0;">Kelola data responden untuk kecamatan Anda (Maksimal 30 per tahun)</p>
        </div>
        <div>
            @if($canAdd)
                <a href="{{ route('angket.create') }}" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 5v14m-7-7h14"/></svg>
                    Tambah Responden
                </a>
            @else
                <button class="btn btn-secondary" disabled title="Kuota maksimal 30 responden tercapai">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                    Kuota Penuh
                </button>
            @endif
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div style="background: var(--green-100); border: 1px solid var(--green); border-radius: var(--r-md); padding: 14px 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="18" height="18" fill="none" stroke="var(--green-600)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            <span style="color: var(--green-600); font-size: 13px; font-weight: 600;">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Alert -->
    @if(session('error'))
        <div style="background: var(--red-100); border: 1px solid var(--red); border-radius: var(--r-md); padding: 14px 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="18" height="18" fill="none" stroke="var(--red)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6m0-6 6 6"/></svg>
            <span style="color: var(--red); font-size: 13px; font-weight: 600;">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Status Card -->
    <div class="card" style="margin-bottom: 24px;">
        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 24px; align-items: center; margin-bottom: 18px;">
                <div>
                    <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--ink-3); margin-bottom: 8px;">Status Pengisian Tahun {{ $year }}</p>
                    <h6 style="font-size: 15px; font-weight: 600; color: var(--ink); margin: 0;">
                        Kecamatan: <strong>{{ Auth::user()->district->name ?? '-' }}</strong>
                    </h6>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--ink-3); margin-bottom: 4px;">Responden</p>
                    <h2 style="font-size: 32px; font-weight: 700; margin: 0;">
                        <span style="color: {{ $count >= 30 ? 'var(--green)' : 'var(--brand-700)' }};">{{ $count }}</span>
                        <span style="color: var(--ink-3); font-weight: 600; font-size: 24px;">/ 30</span>
                    </h2>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="progress">
                <div style="background: {{ $count >= 30 ? 'var(--green)' : 'var(--brand-700)' }}; width: {{ ($count / 30) * 100 }}%;"></div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div style="padding: 18px 24px; border-bottom: 1px solid var(--border);">
            <h6 style="font-size: 15px; font-weight: 700; color: var(--ink); margin: 0;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                Daftar Responden
            </h6>
        </div>
        
        @if($responden->count() > 0)
            <!-- Table -->
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Tanggal Lahir</th>
                            <th>Usia</th>
                            <th>Desa/Kelurahan</th>
                            <th>Status</th>
                            <th style="width: 140px;">Tanggal Input</th>
                            <th style="width: 180px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($responden as $index => $r)
                            <tr>
                                <td style="color: var(--ink-3);">{{ $responden->firstItem() + $index }}</td>
                                <td><strong>{{ $r->nama }}</strong></td>
                                <td>{{ ucfirst($r->jenis_kelamin) }}</td>
                                <td>{{ $r->tanggal_lahir->format('d/m/Y') }}</td>
                                <td>{{ $r->tanggal_lahir->age }} th</td>
                                <td>{{ $r->desa_kelurahan }}</td>
                                <td>
                                    @if($r->status === 'submitted')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                                <td style="color: var(--ink-3);">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                        <a href="{{ route('angket.edit', $r->id) }}" class="btn btn-sm btn-outline" title="Edit">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        @if($r->status === 'submitted')
                                            <a href="{{ route('angket.pdf', $r->id) }}" class="btn btn-sm btn-green" title="Cetak PDF">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8m8 4H8m2-8H8"/></svg>
                                            </a>
                                        @endif
                                        <form action="{{ route('angket.destroy', $r->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus responden {{ $r->nama }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 6h18m-2 0v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6m3 0V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div style="padding: 18px 24px; border-top: 1px solid var(--border);">
                {{ $responden->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 64px 24px;">
                <svg width="80" height="80" fill="none" stroke="var(--border)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="margin-bottom: 20px; opacity: 0.5;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                <h6 style="font-size: 16px; font-weight: 700; color: var(--ink-2); margin-bottom: 8px;">Belum Ada Responden</h6>
                <p style="font-size: 13px; color: var(--ink-3); margin-bottom: 24px;">Mulai tambahkan responden untuk mengisi angket tahun {{ $year }}</p>
                @if($canAdd)
                    <a href="{{ route('angket.create') }}" class="btn btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 5v14m-7-7h14"/></svg>
                        Tambah Responden Pertama
                    </a>
                @else
                    <p style="font-size: 12px; color: var(--red); font-weight: 600;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 4px;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3ZM12 9v4m0 4h.01"/></svg>
                        Kuota maksimal (30 responden) tercapai
                    </p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
