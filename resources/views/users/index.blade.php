@extends('layouts.app')
@section('title', 'Manajemen User — IPO')

@section('content')
<div class="anim-fade" style="display:flex;flex-direction:column;gap:14px">
  <div class="page-head">
    <h1 style="font-size:18px;font-weight:700;color:var(--ink)">Manajemen User</h1>
    <div class="no-print" style="display:flex;gap:8px">
      <form method="POST" action="/users/register-toggle" onsubmit="return confirm('Ubah status pendaftaran?')">@csrf<button class="btn btn-secondary btn-sm" type="submit">{{ $tutup ? 'Buka pendaftaran' : 'Tutup pendaftaran' }}</button></form>
      <a href="/users/tambah" class="btn btn-primary btn-sm">+ Tambah User</a>
    </div>
  </div>
  <p style="font-size:12.5px;color:var(--ink-3)">Kelola akun admin, operator &amp; user · {{ $users->total() }} user</p>
  <form method="GET" action="/users" class="toolbar no-print">
    <input type="text" name="q" class="input" style="max-width:240px" placeholder="Cari nama/username…" value="{{ $q }}">
    <select name="district_id" class="input" style="max-width:200px">
      <option value="">Semua Kecamatan</option>
      @foreach($allDistricts as $d)
        <option value="{{ $d->id }}" {{ request('district_id') == $d->id ? 'selected' : '' }}>{{ $d->name }} ({{ $d->city_name }})</option>
      @endforeach
    </select>
    <button class="btn btn-secondary btn-sm" type="submit">Filter</button>
    <a class="btn btn-secondary btn-sm" href="/users/ekspor?q={{ urlencode($q) }}">⭳ Ekspor CSV</a>
  </form>
  <div class="table-wrap">
    <table class="table">
      <thead><tr>@foreach([['full_name','Nama'],['username','Username'],['role','Peran']] as [$k,$l])<th><a href="?{{ http_build_query(array_merge(request()->query(), ['sort' => $k, 'dir' => ($sort === $k && $dir === 'asc' ? 'desc' : 'asc')])) }}" style="color:inherit">{{ $l }}@if($sort === $k){{ $dir === 'asc' ? ' ▲' : ' ▼' }}@endif</a></th>@endforeach<th>Kab/Kota</th><th>Kecamatan</th><th class="no-print">Aksi</th></tr></thead>
      <tbody>
        @foreach($users as $usr)
          <tr>
            <td><strong>{{ $usr->full_name }}</strong></td>
            <td>{{ $usr->username }}</td>
            <td>
              @php
                $roleLabel = match($usr->role) {
                  'superadmin' => 'Super Admin',
                  'admin_city' => 'Admin Kota',
                  'operator' => 'Operator',
                  default => ucfirst($usr->role),
                };
                $roleBadge = match($usr->role) {
                  'superadmin' => 'badge-blue',
                  'admin_city' => 'badge-cukup',
                  'operator' => 'badge-neutral',
                  default => 'badge-neutral',
                };
              @endphp
              <span class="badge {{ $roleBadge }}">{{ $roleLabel }}</span>
            </td>
            <td>{{ $usr->city_name ?? '—' }}</td>
            <td>{{ $usr->district_name ?? '—' }}</td>
            <td class="no-print" style="white-space:nowrap">
              <a href="/users/{{ $usr->id }}/ubah" class="btn btn-secondary btn-sm">Ubah</a>
              <button type="button" class="btn btn-danger btn-sm" onclick="askDelete('/users/{{ $usr->id }}')">Hapus</button>
              <form method="POST" action="/users/{{ $usr->id }}/reset" style="display:inline">@csrf<button class="btn btn-secondary btn-sm" type="submit" title="Buat token reset">Reset</button></form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div>{{ $users->links() }}</div>
</div>

<div id="delModal" role="dialog" aria-modal="true" aria-label="Konfirmasi hapus" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px">
  <div style="position:absolute;inset:0;background:rgba(30,17,60,.55)" onclick="closeDelete()"></div>
  <div class="card anim-scale" style="position:relative;padding:24px;width:100%;max-width:380px">
    <h3 style="font-size:16px;font-weight:700;color:var(--ink)">Hapus user?</h3>
    <p style="font-size:13px;margin:8px 0 20px;color:var(--ink-2)">Akun yang dihapus tidak dapat dikembalikan.</p>
    <div style="display:flex;gap:8px">
      <button type="button" class="btn btn-secondary" style="flex:1" onclick="closeDelete()">Batal</button>
      <form id="delForm" method="POST" style="flex:1;display:flex">@csrf @method('DELETE')
        <button type="submit" class="btn" style="flex:1;background:var(--red);color:#fff">Hapus</button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function askDelete(url) { document.getElementById('delForm').action = url; document.getElementById('delModal').style.display = 'flex'; const f = document.querySelector('#delModal button[type=submit]'); if (f) setTimeout(() => f.focus(), 60); }
function closeDelete() { document.getElementById('delModal').style.display = 'none'; }
</script>
@endpush
