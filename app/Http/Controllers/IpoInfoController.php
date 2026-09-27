<?php

namespace App\Http\Controllers;

class IpoInfoController extends Controller
{
    public function index()
    {
        $ipoInfo = [
            'tujuan' => 'Mengukur dan memantau pembangunan olahraga di Kalimantan Timur secara holistik dan komprehensif.',
            'fungsi' => [
                'Monitoring kinerja sektor olahraga per wilayah (provinsi, kabupaten/kota, kecamatan)',
                'Evaluasi dampak program pengembangan olahraga',
                'Perencanaan strategis berbasis data untuk peningkatan prestasi olahraga',
                'Akuntabilitas dan transparansi terhadap stakeholder'
            ],
            'konteks' => 'IPO merupakan komposit dari 9 dimensi yang mencerminkan ekosistem olahraga yang sehat. Setiap dimensi diukur dengan indikator spesifik dan bobot yang dapat disesuaikan sesuai prioritas policy.',
        ];

        $dimensi = [
            [
                'id' => 'D1',
                'nama' => 'SDM Olahraga',
                'deskripsi' => 'Ketersediaan dan kualitas sumber daya manusia di bidang olahraga',
                'indikator' => 'Jumlah pelatih, atlet, official, tenaga medis olahraga yang berkualifikasi',
                'konteks' => 'SDM yang terlatih dan bersertifikat adalah fondasi untuk pengembangan olahraga yang berkelanjutan',
                'bobot' => 21.3
            ],
            [
                'id' => 'D2',
                'nama' => 'Ruang Terbuka (Fasilitas Olahraga)',
                'deskripsi' => 'Ketersediaan dan aksesibilitas fasilitas olahraga di masyarakat',
                'indikator' => 'Jumlah lapangan, stadion, kolam renang, gym, dan fasilitas olahraga lainnya yang dapat diakses publik',
                'konteks' => 'Fasilitas yang memadai dan mudah diakses mendorong partisipasi aktif masyarakat dalam berolahraga',
                'bobot' => 21.3
            ],
            [
                'id' => 'D3',
                'nama' => 'Literasi Fisik',
                'deskripsi' => 'Pengetahuan, keterampilan, dan pemahaman masyarakat tentang pentingnya aktivitas fisik',
                'indikator' => 'Frekuensi aktivitas fisik, pemahaman manfaat olahraga, minat terhadap olahraga dalam kehidupan sehari-hari',
                'konteks' => 'Literasi fisik yang tinggi menciptakan budaya hidup sehat dan aktif di masyarakat',
                'bobot' => 10
            ],
            [
                'id' => 'D4',
                'nama' => 'Partisipasi Olahraga',
                'deskripsi' => 'Tingkat keikutsertaan masyarakat dalam kegiatan olahraga terstruktur dan tidak terstruktur',
                'indikator' => 'Persentase populasi yang secara aktif berpartisipasi dalam olahraga minimal 1 jam per minggu',
                'konteks' => 'Partisipasi tinggi menunjukkan efektivitas program olahraga dan keterlibatan komunitas yang kuat',
                'bobot' => 7
            ],
            [
                'id' => 'D5',
                'nama' => 'Kebugaran Jasmani',
                'deskripsi' => 'Kondisi fisik dan derajat kebugaran jasmani penduduk',
                'indikator' => 'Rata-rata skor kebugaran jasmani berdasarkan tes standar (VO2 max, kekuatan, daya tahan, fleksibilitas)',
                'konteks' => 'Kebugaran jasmani yang baik merupakan indikator kesuksesan program olahraga dan kesehatan masyarakat',
                'bobot' => 6
            ],
            [
                'id' => 'D6',
                'nama' => 'Kesehatan',
                'deskripsi' => 'Status kesehatan dan pencegahan penyakit tidak menular melalui olahraga',
                'indikator' => 'Persepsi masyarakat terhadap kesehatan, gangguan kesehatan, kepuasan terhadap kesehatan diri',
                'konteks' => 'Olahraga teratur berkontribusi pada pencegahan penyakit kronis dan peningkatan kualitas hidup',
                'bobot' => 6
            ],
            [
                'id' => 'D7',
                'nama' => 'Perkembangan Personal',
                'deskripsi' => 'Dampak olahraga terhadap perkembangan karakter, resiliensi, dan kesejahteraan mental',
                'indikator' => 'Persepsi tentang tantangan, kepercayaan diri, kemampuan mengatasi masalah, kepercayaan terhadap orang lain',
                'konteks' => 'Olahraga membangun karakter, disiplin, kepemimpinan, dan ketahanan mental yang penting bagi pengembangan SDM',
                'bobot' => 4
            ],
            [
                'id' => 'D8',
                'nama' => 'Ekonomi Olahraga',
                'deskripsi' => 'Kontribusi sektor olahraga terhadap perekonomian lokal',
                'indikator' => 'Pengeluaran masyarakat untuk peralatan olahraga, jasa olahraga, dan aktivitas olahraga',
                'konteks' => 'Ekonomi olahraga yang berkembang menciptakan lapangan kerja dan meningkatkan pertumbuhan ekonomi lokal',
                'bobot' => 3
            ],
            [
                'id' => 'D9',
                'nama' => 'Performa (Prestasi Olahraga)',
                'deskripsi' => 'Capaian prestasi atlet dan tim di kompetisi lokal, nasional, dan internasional',
                'indikator' => 'Jumlah medali, juara, atlet yang masuk seleksi nasional, pencapaian di PON dan kejuaraan internasional',
                'konteks' => 'Prestasi yang baik meningkatkan kepercayaan publik, dukungan investasi, dan motivasi generasi muda untuk berolahraga',
                'bobot' => 21.3
            ],
        ];

        $metodologi = [
            'perhitungan' => 'IPO dihitung sebagai rata-rata tertimbang dari 9 dimensi dengan bobot yang telah ditentukan',
            'skala' => 'IPO berkisar dari 0 hingga 100',
            'kategori' => [
                ['range' => '0 - 20', 'label' => 'Sangat Rendah', 'warna' => 'danger'],
                ['range' => '21 - 40', 'label' => 'Rendah', 'warna' => 'warning'],
                ['range' => '41 - 60', 'label' => 'Sedang', 'warna' => 'info'],
                ['range' => '61 - 80', 'label' => 'Tinggi', 'warna' => 'success'],
                ['range' => '81 - 100', 'label' => 'Sangat Tinggi', 'warna' => 'success'],
            ],
            'update' => 'IPO diperbarui setiap tahun berdasarkan data yang dikumpulkan dari seluruh kabupaten/kota di Kalimantan Timur'
        ];

        return view('ipo-info', compact('ipoInfo', 'dimensi', 'metodologi'));
    }
}
