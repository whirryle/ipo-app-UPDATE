@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding: 24px 16px;">
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 24px; font-weight: 700; color: var(--ink); margin-bottom: 16px;">
            {{ isset($responden) ? 'Edit Responden' : 'Tambah Responden Baru' }}
        </h1>
        
        <!-- Progress Bar -->
        <div style="height: 8px; background: var(--border); border-radius: var(--r-md); overflow: hidden; margin-bottom: 20px;">
            <div id="progressBar" style="width: 12.5%; height: 100%; background: var(--brand-700); transition: width 0.3s ease;"></div>
        </div>
        
        <!-- Step Indicators -->
        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
            <div style="background: var(--brand-700); color: #fff; padding: 8px 12px; border-radius: var(--r-sm); font-size: 12px; font-weight: 700;">
                Step <span id="currentStep">1</span> / 8
            </div>
            <small style="font-size: 13px; color: var(--ink-3);">
                <span id="stepTitle">A. Identitas</span>
            </small>
        </div>
    </div>

    @if($errors->any())
        <div style="background: var(--red-100); border: 1px solid var(--red); border-radius: var(--r-md); padding: 16px; margin-bottom: 20px;">
            <strong style="color: var(--red);">Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 20px; color: var(--red); font-size: 13px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="wizardForm" method="POST" action="{{ isset($responden) ? route('angket.update', $responden->id) : route('angket.store') }}">
        @csrf
        @if(isset($responden))
            @method('PUT')
            <input type="hidden" name="responden_id" value="{{ $responden->id }}">
        @else
            <input type="hidden" name="responden_id" value="">
        @endif
        
        <input type="hidden" name="step" id="stepInput" value="1">
        <input type="hidden" name="status" id="statusInput" value="draft">

        <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden;">
            <div style="padding: 28px 24px;">
                <!-- Step 1: Identitas -->
                @include('angket.partials.step1-identitas')

                <!-- Step 2: Literasi Fisik -->
                @include('angket.partials.step2-literasi')

                <!-- Step 3: Partisipasi -->
                @include('angket.partials.step3-partisipasi')

                <!-- Step 4: Perkembangan Personal -->
                @include('angket.partials.step4-personal')

                <!-- Step 5: Kesehatan -->
                @include('angket.partials.step5-kesehatan')

                <!-- Step 6: Ekonomi -->
                @include('angket.partials.step6-ekonomi')

                <!-- Step 7: Kebugaran -->
                @include('angket.partials.step7-kebugaran')

                <!-- Step 8: Review & Submit -->
                @include('angket.partials.step8-review')
            </div>

            <!-- Navigation Buttons -->
            <div style="background: var(--white); padding: 20px 24px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <button type="button" id="prevBtn" style="display: none; background: var(--neutral-400); color: #fff; border: none; padding: 12px 20px; border-radius: var(--r-sm); font-size: 13px; font-weight: 600; cursor: pointer;">
                    ← Kembali
                </button>
                <div id="navPlaceholder"></div>
                
                <button type="button" id="nextBtn" style="background: var(--brand-600); color: #fff; border: none; padding: 12px 24px; border-radius: var(--r-sm); font-size: 13px; font-weight: 600; cursor: pointer;">
                    Lanjut ke Step Berikutnya →
                </button>
                <button type="submit" id="submitBtn" style="display: none; background: var(--green); color: #fff; border: none; padding: 12px 24px; border-radius: var(--r-sm); font-size: 13px; font-weight: 600; cursor: pointer;">
                    ✓ Simpan Angket
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let currentStep = 1;
const totalSteps = 8;
const steps = [
    { title: 'A. Identitas', id: 'step1' },
    { title: 'B. Literasi Fisik', id: 'step2' },
    { title: 'C. Partisipasi', id: 'step3' },
    { title: 'D. Perkembangan Personal', id: 'step4' },
    { title: 'E. Kesehatan', id: 'step5' },
    { title: 'F. Ekonomi', id: 'step6' },
    { title: 'G. Kebugaran', id: 'step7' },
    { title: 'Review & Submit', id: 'step8' }
];

// Load existing responden data if editing
@if(isset($responden))
    currentStep = {{ session('currentStep', 1) }};
@endif

function showStep(step) {
    currentStep = step;
    
    // Hide all steps
    document.querySelectorAll('[id^="step"]').forEach(el => {
        if (el.id.match(/^step\d+$/)) {
            el.style.display = 'none';
        }
    });
    
    // Show current step
    const stepElement = document.getElementById('step' + currentStep);
    if (stepElement) {
        stepElement.style.display = 'block';
    }
    
    // Update progress bar
    const progress = (currentStep / totalSteps) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
    document.getElementById('progressBar').setAttribute('aria-valuenow', currentStep);
    
    // Update step display
    document.getElementById('currentStep').textContent = currentStep;
    document.getElementById('stepTitle').textContent = steps[currentStep - 1].title;
    document.getElementById('stepInput').value = currentStep;
    
    // Update buttons
    document.getElementById('prevBtn').style.display = currentStep > 1 ? 'block' : 'none';
    document.getElementById('nextBtn').style.display = currentStep < totalSteps ? 'block' : 'none';
    document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'block' : 'none';
    
    // Populate review data when reaching step 8
    if (currentStep === 8) {
        populateReview();
    }
    
    // Scroll to top
    window.scrollTo(0, 0);
}

document.getElementById('nextBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Save current step data
    const formData = new FormData(document.getElementById('wizardForm'));
    formData.append('step', currentStep);
    
    fetch('{{ isset($responden) ? route("angket.update", $responden->id) : route("angket.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update responden_id if creating new
            if (!document.querySelector('input[name="responden_id"]').value) {
                document.querySelector('input[name="responden_id"]').value = data.responden_id;
                // Update form action for subsequent requests
                document.getElementById('wizardForm').action = '{{ url("/data") }}/' + data.responden_id;
                document.querySelector('input[name="_method"]').value = 'PUT';
            }
            
            // Move to next step
            if (currentStep < totalSteps) {
                showStep(currentStep + 1);
            }
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => console.error('Error:', error));
});

document.getElementById('submitBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Set status to submitted
    document.getElementById('statusInput').value = 'submitted';
    
    // Submit final data
    const formData = new FormData(document.getElementById('wizardForm'));
    formData.append('step', 8);
    
    fetch('{{ isset($responden) ? route("angket.update", $responden->id) : route("angket.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Angket berhasil disimpan!');
            window.location.href = '{{ route("angket.index") }}';
        } else {
            alert('❌ Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat menyimpan');
    });
});

document.getElementById('prevBtn').addEventListener('click', function() {
    if (currentStep > 1) {
        showStep(currentStep - 1);
    }
});

// Conditional logic for Partisipasi & Ekonomi
document.addEventListener('change', function(e) {
    if (e.target.name === 'partisipasi_minggu_lalu') {
        togglePartisipasiFields(e.target.value);
    }
    if (e.target.name === 'ekonomi_belanja') {
        toggleEkonomiFields(e.target.value);
    }
});

function togglePartisipasiFields(value) {
    const fields = document.querySelectorAll('[data-conditional="partisipasi"]');
    fields.forEach(field => {
        field.style.display = value === 'ya' ? 'block' : 'none';
        // Clear values if hidden
        if (value === 'tidak') {
            field.querySelectorAll('input, select, textarea').forEach(input => {
                input.value = '';
            });
        }
    });
}

function toggleEkonomiFields(value) {
    const fields = document.querySelectorAll('[data-conditional="ekonomi"]');
    fields.forEach(field => {
        field.style.display = value === 'ya' ? 'block' : 'none';
        // Clear values if hidden
        if (value === 'tidak') {
            field.querySelectorAll('input, select, textarea').forEach(input => {
                input.value = '';
            });
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    showStep(currentStep);
    
    // Check conditional fields on load
    const partisipasiValue = document.querySelector('[name="partisipasi_minggu_lalu"]:checked');
    if (partisipasiValue) {
        togglePartisipasiFields(partisipasiValue.value);
    }
    
    const ekonomiValue = document.querySelector('[name="ekonomi_belanja"]:checked');
    if (ekonomiValue) {
        toggleEkonomiFields(ekonomiValue.value);
    }
});

// Function to populate review data from form inputs
function populateReview() {
    // Helper: get display value from input
    function getValue(name, type = 'text') {
        const element = document.querySelector('[name="' + name + '"]');
        if (!element) return '-';
            
        if (type === 'radio' || type === 'checkbox') {
            const checked = document.querySelector('[name="' + name + '"]:checked');
            if (!checked) return '-';
            return checked.value === 'ya' ? 'Ya' : 'Tidak';
        }
            
        if (type === 'scale') {
            const checked = document.querySelector('[name="' + name + '"]:checked');
            return checked ? checked.value : '-';
        }
            
        return element.value || '-';
    }
        
    // Helper: get multiple checkboxes
    function getCheckboxes(name, options) {
        const checked = document.querySelectorAll('[name="' + name + '"]:checked');
        if (!checked.length) return '-';
        const values = Array.from(checked).map(cb => {
            return options[cb.value] || cb.value;
        });
        return values.join(', ');
    }
        
    // A. IDENTITAS
    document.getElementById('review_nama').textContent = getValue('nama');
    document.getElementById('review_jenis_kelamin').textContent = getValue('jenis_kelamin') === 'pria' ? 'Pria' : 'Wanita';
    document.getElementById('review_tanggal_lahir').textContent = getValue('tanggal_lahir');
    document.getElementById('review_tinggi_badan').textContent = getValue('tinggi_badan');
    document.getElementById('review_berat_badan').textContent = getValue('berat_badan');
    document.getElementById('review_pendidikan').textContent = getValue('pendidikan');
    document.getElementById('review_pekerjaan').textContent = getValue('pekerjaan');
    document.getElementById('review_pendapatan').textContent = getValue('pendapatan');
    document.getElementById('review_desa_kelurahan').textContent = getValue('desa_kelurahan');
    document.getElementById('review_kecamatan').textContent = getValue('kecamatan');
    document.getElementById('review_kabupaten_kota').textContent = getValue('kabupaten_kota');
    document.getElementById('review_provinsi').textContent = getValue('provinsi');
        
    // B. LITERASI FISIK
    document.getElementById('review_literasi_frekuensi').textContent = getValue('literasi_frekuensi', 'scale');
    document.getElementById('review_literasi_durasi').textContent = getValue('literasi_durasi', 'scale');
    document.getElementById('review_literasi_intensitas').textContent = getValue('literasi_intensitas', 'scale');
    document.getElementById('review_literasi_kesenangan').textContent = getValue('literasi_kesenangan', 'scale');
    document.getElementById('review_literasi_membaca').textContent = getValue('literasi_membaca', 'scale');
    document.getElementById('review_literasi_menonton').textContent = getValue('literasi_menonton', 'scale');
    document.getElementById('review_literasi_murah').textContent = getValue('literasi_murah', 'scale');
        
    // C. PARTISIPASI
    const partisipasiYa = getValue('partisipasi_minggu_lalu', 'radio') === 'Ya';
    document.getElementById('review_partisipasi_minggu_lalu').textContent = partisipasiYa ? 'Ya' : 'Tidak';
        
    if (partisipasiYa) {
        document.getElementById('review_partisipasi_detail').style.display = 'block';
        document.getElementById('review_partisipasi_frekuensi').textContent = getValue('partisipasi_frekuensi', 'scale');
        document.getElementById('review_partisipasi_durasi').textContent = getValue('partisipasi_durasi', 'scale');
        document.getElementById('review_partisipasi_intensitas').textContent = getValue('partisipasi_intensitas', 'scale');
        document.getElementById('review_partisipasi_jenis').textContent = getValue('partisipasi_jenis');
        document.getElementById('review_partisipasi_tujuan').textContent = getValue('partisipasi_tujuan');
        document.getElementById('review_partisipasi_tempat').textContent = getValue('partisipasi_tempat');
    } else {
        document.getElementById('review_partisipasi_detail').style.display = 'none';
    }
        
    // D. PERKEMBANGAN PERSONAL
    document.getElementById('review_personal_tantangan').textContent = getValue('personal_tantangan', 'scale');
    document.getElementById('review_personal_putus_asa').textContent = getValue('personal_putus_asa', 'scale');
    document.getElementById('review_personal_solusi').textContent = getValue('personal_solusi', 'scale');
    document.getElementById('review_personal_pertemuan').textContent = getValue('personal_pertemuan', 'scale');
    document.getElementById('review_personal_curiga').textContent = getValue('personal_curiga', 'scale');
    document.getElementById('review_personal_percaya').textContent = getValue('personal_percaya', 'scale');
        
    // E. KESEHATAN
    document.getElementById('review_kesehatan_gangguan').textContent = getValue('kesehatan_gangguan', 'scale');
    document.getElementById('review_kesehatan_puas').textContent = getValue('kesehatan_puas', 'scale');
    document.getElementById('review_kesehatan_kesiapan').textContent = getValue('kesehatan_kesiapan', 'scale');
    document.getElementById('review_kesehatan_yakin').textContent = getValue('kesehatan_yakin', 'scale');
    document.getElementById('review_kesehatan_karakter').textContent = getValue('kesehatan_karakter', 'scale');
    document.getElementById('review_kesehatan_tujuan').textContent = getValue('kesehatan_tujuan', 'scale');
        
    // F. EKONOMI
    const ekonomiYa = getValue('ekonomi_belanja', 'radio') === 'Ya';
    document.getElementById('review_ekonomi_belanja').textContent = ekonomiYa ? 'Ya' : 'Tidak';
        
    if (ekonomiYa) {
        document.getElementById('review_ekonomi_detail').style.display = 'block';
        document.getElementById('review_ekonomi_jumlah').textContent = getValue('ekonomi_jumlah');
            
        const barangOptions = {
            'sepatu': 'Sepatu',
            'pakaian': 'Pakaian',
            'peralatan': 'Peralatan',
            'aksesoris': 'Aksesoris',
            'makan_minum': 'Biaya Makan Minum',
            'suplemen': 'Suplemen/Nutrisi',
            'buku': 'Buku/Majalah/Koran',
            'cindera_mata': 'Cindera Mata'
        };
        document.getElementById('review_ekonomi_barang').textContent = getCheckboxes('ekonomi_barang[]', barangOptions);
            
        const jasaOptions = {
            'tiket': 'Tiket Pertandingan',
            'tv_berbayar': 'Langganan TV Berbayar',
            'pelatih': 'Membayar Pelatih',
            'tempat_latihan': 'Membayar Tempat Latihan',
            'sewa_peralatan': 'Sewa Peralatan',
            'perjalanan': 'Biaya Perjalanan',
            'paramedik': 'Jasa Paramedik'
        };
        document.getElementById('review_ekonomi_jasa').textContent = getCheckboxes('ekonomi_jasa[]', jasaOptions);
    } else {
        document.getElementById('review_ekonomi_detail').style.display = 'none';
    }
        
    // G. KEBUGARAN
    document.getElementById('review_kebugaran_level').textContent = getValue('kebugaran_level');
    document.getElementById('review_kebugaran_balikan').textContent = getValue('kebugaran_balikan');
    document.getElementById('review_kebugaran_vo2max').textContent = getValue('kebugaran_vo2max');
}
    
// Add styles for wizard
const wizardStyles = `
<style>
@media (max-width: 576px) {
    #wizardForm > div > div {
        padding: 20px 16px;
    }
    #wizardForm .card-footer, #wizardForm > div > div:last-child {
        padding: 16px;
    }
}
</style>
`;
document.head.insertAdjacentHTML('beforeend', wizardStyles);
</script>

<style>
    [id^="step"] {
        display: none;
    }
    
    #step1 {
        display: block;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .scale-options {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .scale-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .scale-option input[type="radio"] {
        cursor: pointer;
        width: 18px;
        height: 18px;
    }
    
    .scale-option label {
        cursor: pointer;
        margin-bottom: 0;
    }
</style>
@endsection
