<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Seed 4 kandidat pemilihan Ketua Umum Paskibra SMKN 6 Jember.
     */
    public function run(): void
    {
        $candidates = [
            [
                'paslon_number' => 1,
                'leader_name' => 'Kandidat 1',
                'photo' => null,
                'vision' => 'Mewujudkan Paskibra SMKN 6 Jember yang berkarakter tangguh, berdisiplin tinggi, berprestasi, dan menjunjung tinggi kekeluargaan serta jiwa kepemimpinan.',
                'mission' => "1. Menanamkan nilai kedisiplinan dan tanggung jawab dalam setiap latihan.\n2. Mengembangkan potensi kepemimpinan dan rasa percaya diri anggota.\n3. Meningkatkan prestasi Paskibra SMKN 6 Jember di tingkat kabupaten dan provinsi.\n4. Mempererat tali persaudaraan dan solidaritas antar angkatan.",
            ],
            [
                'paslon_number' => 2,
                'leader_name' => 'Kandidat 2',
                'photo' => null,
                'vision' => 'Menciptakan generasi Paskibra yang berintegritas, adaptif, profesional, serta aktif berkontribusi positif bagi sekolah dan masyarakat.',
                'mission' => "1. Mengoptimalkan program latihan berbasis metode modern dan efisien.\n2. Membangun komunikasi yang harmonis antara pengurus, anggota, dan pembina.\n3. Menumbuhkan semangat juang, loyalitas, dan cinta tanah air.\n4. Mengadakan program bakti sosial dan kegiatan kreatif internal.",
            ],
            [
                'paslon_number' => 3,
                'leader_name' => 'Kandidat 3',
                'photo' => null,
                'vision' => 'Menjadikan Paskibra SMKN 6 Jember sebagai organisasi teladan yang unggul dalam kedisiplinan, berakhlak mulia, dan berdaya saing tinggi.',
                'mission' => "1. Memperkuat pondasi dasar PBB dan formasi variasi dengan standar kompetisi.\n2. Menjalin hubungan baik dan silaturahmi dengan satuan Paskibra sekolah lain.\n3. Mendorong setiap anggota untuk aktif, solutif, dan beretika santun.\n4. Menjaga keterbukaan dan transparansi dalam kepengurusan.",
            ],
            [
                'paslon_number' => 4,
                'leader_name' => 'Kandidat 4',
                'photo' => null,
                'vision' => 'Mewujudkan Paskibra SMKN 6 Jember yang solid, mandiri, berjiwa ksatria, dan siap menghadapi tantangan era modern.',
                'mission' => "1. Menyusun jadwal kegiatan yang terstruktur dan terukur.\n2. Memberikan ruang aspirasi dan kreativitas bagi seluruh anggota.\n3. Membiasakan sikap tepat waktu, tegas, dan berwibawa.\n4. Mempertahankan tradisi prestasi dan mengharumkan nama almamater.",
            ],
        ];

        foreach ($candidates as $data) {
            Candidate::updateOrCreate(
                ['paslon_number' => $data['paslon_number']],
                $data
            );
        }
    }
}
