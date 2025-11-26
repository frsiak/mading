<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\User;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        // Buat kategori jika belum ada
        $kategoriPrestasi = Kategori::firstOrCreate(['nama_kategori' => 'Prestasi']);
        $kategoriOlahraga = Kategori::firstOrCreate(['nama_kategori' => 'Olahraga']);
        $kategoriSeni = Kategori::firstOrCreate(['nama_kategori' => 'Seni']);
        $kategoriAkademik = Kategori::firstOrCreate(['nama_kategori' => 'Akademik']);

        // Ambil user guru
        $guru = User::where('role', 'guru')->first();

        $artikelPrestasi = [
            [
                'judul' => 'Prestasi Siswa dalam Olimpiade Sains Nasional 2025',
                'isi' => 'Siswa-siswi sekolah meraih prestasi gemilang dalam Olimpiade Sains Nasional 2025. Tim olimpiade sains berhasil meraih medali emas dan perak.\n\n**Daftar Pemenang:**\n• Andi Pratama - Medali Emas Fisika\n• Sari Dewi - Medali Perak Kimia\n• Budi Santoso - Medali Perunggu Biologi\n\n**Persiapan Intensif:**\nPrestasi ini merupakan hasil kerja keras siswa-siswa terbaik yang telah mempersiapkan diri selama 6 bulan. Mereka mengikuti berbagai latihan intensif setiap hari setelah jam sekolah dan bimbingan dari guru-guru berpengalaman.\n\n**Dukungan Sekolah:**\nSekolah memberikan dukungan penuh dengan menyediakan laboratorium khusus, buku-buku referensi terbaru, dan mengundang pembicara ahli dari universitas ternama.\n\nDengan prestasi ini, sekolah semakin bangga dan termotivasi untuk terus mengembangkan potensi siswa di bidang sains dan teknologi.',
                'tanggal' => '2025-11-12',
                'kategori' => $kategoriPrestasi->id_kategori
            ],
            [
                'judul' => 'Juara 1 Lomba Basket Antar SMA Se-Provinsi',
                'isi' => 'Tim basket putra sekolah berhasil meraih juara 1 dalam Lomba Basket Antar SMA Se-Provinsi yang diselenggarakan di GOR Utama.\n\n**Perjalanan Menuju Juara:**\n• Babak Penyisihan: Mengalahkan 8 tim dengan skor rata-rata 75-60\n• Semifinal: Menang tipis 68-65 melawan SMA Negeri 3\n• Final: Menang telak 82-70 melawan SMA Swasta Favorit\n\n**Pemain Terbaik:**\n• MVP Tournament: Rizky Pratama (Kapten Tim)\n• Top Scorer: Ahmad Fauzi (rata-rata 18 poin per game)\n• Best Defense: Doni Setiawan\n\n**Pelatihan Rutin:**\nTim berlatih setiap hari Senin, Rabu, dan Jumat pukul 15.30-17.30 di lapangan basket sekolah. Pelatih profesional dari klub basket kota memberikan bimbingan teknik dan strategi.\n\nPrestasi ini membuktikan dedikasi dan kerja keras seluruh anggota tim basket sekolah.',
                'tanggal' => '2025-11-10',
                'kategori' => $kategoriOlahraga->id_kategori
            ],
            [
                'judul' => 'Siswa Meraih Juara Harapan 1 Lomba Melukis Tingkat Nasional',
                'isi' => 'Siswi kelas XI IPA, Maya Sari, berhasil meraih Juara Harapan 1 dalam Lomba Melukis Tingkat Nasional dengan tema "Keindahan Alam Indonesia".\n\n**Detail Kompetisi:**\n• Peserta: 500 siswa dari seluruh Indonesia\n• Tema: "Keindahan Alam Indonesia"\n• Waktu: 3 jam untuk menyelesaikan karya\n• Teknik: Bebas (cat air, cat minyak, atau akrilik)\n\n**Karya Pemenang:**\nMaya melukis pemandangan Danau Toba dengan teknik cat air yang memukau. Lukisannya menampilkan gradasi warna biru danau yang menyatu dengan langit sore, dikelilingi perbukitan hijau yang asri.\n\n**Proses Kreatif:**\n"Saya terinspirasi dari foto liburan keluarga ke Danau Toba tahun lalu. Keindahan alamnya sangat membekas di hati," ujar Maya.\n\n**Pembinaan Sekolah:**\nSekolah memiliki ekstrakurikuler seni rupa yang aktif dengan guru pembimbing berpengalaman. Setiap minggu ada workshop teknik melukis dan kunjungan ke galeri seni.\n\nPrestasi Maya membanggakan sekolah dan memotivasi siswa lain untuk mengembangkan bakat seni.',
                'tanggal' => '2025-11-08',
                'kategori' => $kategoriSeni->id_kategori
            ],
            [
                'judul' => 'Tim Debat Bahasa Inggris Raih Juara 2 Tingkat Regional',
                'isi' => 'Tim debat bahasa Inggris sekolah berhasil meraih juara 2 dalam kompetisi debat tingkat regional dengan tema "Technology and Education".\n\n**Anggota Tim Pemenang:**\n• Speaker 1: Putri Maharani (XII IPS 1)\n• Speaker 2: Arief Budiman (XII IPA 2)\n• Speaker 3: Dinda Safitri (XI IPA 1)\n\n**Perjalanan Kompetisi:**\n• Babak Preliminary: 3 kemenangan dari 4 debat\n• Quarterfinal: Menang melawan SMA Negeri 5 (2-1)\n• Semifinal: Menang melawan SMA Swasta Unggulan (3-0)\n• Final: Kalah tipis melawan SMA Negeri 1 (1-2)\n\n**Topik Debat Final:**\n"This house believes that artificial intelligence should replace teachers in classrooms"\n\n**Persiapan Intensif:**\nTim berlatih 3 kali seminggu dengan fokus pada:\n• Research dan fact-checking\n• Public speaking dan delivery\n• Critical thinking dan argumentation\n• Rebuttal techniques\n\n**Pembimbing:**\nMrs. Sarah Johnson (guru bahasa Inggris) dan Mr. David Smith (native speaker volunteer)\n\nPrestasi ini menunjukkan kemampuan berbahasa Inggris dan berpikir kritis siswa yang semakin baik.',
                'tanggal' => '2025-11-05',
                'kategori' => $kategoriAkademik->id_kategori
            ]
        ];

        foreach ($artikelPrestasi as $artikel) {
            Artikel::create([
                'judul' => $artikel['judul'],
                'isi' => $artikel['isi'],
                'tanggal' => $artikel['tanggal'],
                'id_user' => $guru->id_user,
                'id_kategori' => $artikel['kategori'],
                'status' => 'published'
            ]);
        }
    }
}
