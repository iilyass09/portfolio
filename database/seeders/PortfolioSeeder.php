<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        \App\Models\User::create([
            'name' => 'Muhammad Ilyas',
            'email' => 'admin@portfolio.local',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Settings
        $settings = [
            'site_name' => 'MUHAMMAD ILYAS',
            'hero_eyebrow' => 'Halo, Saya Muhammad Ilyas',
            'hero_title_1' => 'UI / UX DESIGN',
            'hero_title_2' => '& E COMMERCE ANALYST',
            'hero_description' => 'Saya adalah UI/UX Designer dan Data Analyst di bidang E Commerce yang berfokus pada menciptakan pengalaman digital yang intuitif, menarik, dan mudah digunakan. Dengan menggabungkan pemahaman mendalam tentang pengguna serta analisis data, saya membantu meningkatkan kualitas pengalaman sekaligus mendorong performa dan konversi bisnis.',
            'profile_photo' => 'img/ilyas.jpeg',
            'about_title' => 'Menciptakan pengalaman digital melalui desain antarmuka dan analisis data.',
            'about_text_1' => 'Saya adalah UI/UX Designer dan Data Analyst dengan latar belakang Informatika, yang berfokus pada perancangan produk digital yang intuitif dan menarik. Saya menggabungkan pemahaman pengguna dengan eksekusi visual yang kuat untuk menciptakan pengalaman yang bermakna.',
            'about_text_2' => 'Dengan pengalaman dalam analisis data e-commerce, saya memanfaatkan data untuk memahami perilaku pengguna, mengoptimalkan performa, serta mendukung pengambilan keputusan yang lebih tepat. Saya juga memiliki pengalaman dalam pengembangan web menggunakan HTML, CSS, PHP, dan JavaScript.',
            'about_text_3' => 'Saya menghubungkan desain, data, dan implementasi untuk mengubah permasalahan kompleks menjadi solusi yang sederhana, fungsional, dan berdampak.',
            'resume_url' => 'https://drive.google.com/file/d/1e5zPwdZpPcHS3sFbC4bchbpK5NuVAE6w/view?usp=sharing',
            'linkedin_url' => 'https://id.linkedin.com/in/muhammad-ilyas-b65090275',
            'spotify_url' => 'https://open.spotify.com/user/31vjzubdaow5vmc7wqos5ycddafq?si=29c7d88774ef4f73',
            'copyright' => '© 2026 Muhammad Ilyas. All rights reserved.',
            'connect_text' => 'Terbuka untuk peluang kolaborasi maupun diskusi lebih lanjut.',
            'education_title' => 'Pendidikan dan Pelatihan',
            'education_subtitle' => 'Fondasi akademik dan pengembangan keahlian',
            'experience_title' => 'Pengalaman Kerja',
            'experience_subtitle' => 'Perjalanan profesional yang membentuk keahlian saya',
            'skills_title' => 'Keahlian Utama',
            'skills_subtitle' => 'Kemampuan teknis dan non-teknis yang saya kuasai',
        ];
        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }

        // Skills
        $skills = [
            ['name' => 'Manajemen Marketplace (Shopee, Tokopedia, TikTok Shop)', 'category' => 'marketplace', 'sort_order' => 1],
            ['name' => 'Manajemen Media Sosial (Instagram)', 'category' => 'marketplace', 'sort_order' => 2],
            ['name' => 'Pengelolaan & Optimasi Produk', 'category' => 'marketplace', 'sort_order' => 3],
            ['name' => 'Manajemen Pesanan & Layanan Pelanggan', 'category' => 'marketplace', 'sort_order' => 4],
            ['name' => 'Pengelolaan Promo, Campaign & Flash Sale', 'category' => 'marketplace', 'sort_order' => 5],
            ['name' => 'Laporan Penjualan & Monitoring Performa', 'category' => 'marketplace', 'sort_order' => 6],
            ['name' => 'UI/UX Design (Wireframe, Prototype, Usability Testing)', 'category' => 'uiux', 'sort_order' => 7],
            ['name' => 'User Research & Design Thinking', 'category' => 'uiux', 'sort_order' => 8],
            ['name' => 'Tools Desain (Figma, FigJam, Adobe XD)', 'category' => 'uiux', 'sort_order' => 9],
            ['name' => 'Microsoft Office (Word, Excel – Lanjutan)', 'category' => 'data', 'sort_order' => 10],
            ['name' => 'Analisis & Pengolahan Data', 'category' => 'data', 'sort_order' => 11],
            ['name' => 'Dashboard & Pelaporan Data', 'category' => 'data', 'sort_order' => 12],
            ['name' => 'Pengembangan Web (HTML, CSS, JavaScript, PHP)', 'category' => 'technical', 'sort_order' => 13],
            ['name' => 'Pengembangan Mobile Dasar (Kotlin)', 'category' => 'technical', 'sort_order' => 14],
        ];
        foreach ($skills as $s) {
            Skill::create($s);
        }

        // Educations
        Education::create(['institution' => 'SMK Negeri 8 Bandung', 'degree' => 'Teknik Elektronika', 'start_date' => '2018', 'end_date' => '2021', 'sort_order' => 1]);
        Education::create(['institution' => 'Institut Teknologi Nasional Bandung', 'degree' => 'Informatika', 'start_date' => '2021', 'end_date' => '2025', 'sort_order' => 2]);
        Education::create(['institution' => 'Infinite Learning', 'degree' => 'UI/UX Design & Mobile Developer', 'start_date' => '2024', 'end_date' => null, 'sort_order' => 3]);

        // Experiences
        Experience::create([
            'title' => 'Marketplace Specialist – Bisnis Pribadi (Thrifting)',
            'company' => 'Bisnis Pribadi (Thrifting)',
            'location' => 'Bandung',
            'job_type' => 'full_time',
            'period' => '2021 - 2025',
            'description' => 'Mengelola akun media sosial dan marketplace (Instagram, Tokopedia, Shopee, TikTok) untuk usaha thrifting, termasuk katalog produk dan interaksi pelanggan. Membuat konten visual (feed, story, promosi) untuk meningkatkan branding dan engagement, serta menjalankan strategi digital marketing seperti Instagram Ads dan promo marketplace untuk memperluas jangkauan dan mendorong penjualan.',
            'sort_order' => 1,
        ]);
        Experience::create([
            'title' => 'UI/UX Designer – Freelance',
            'company' => 'Freelance',
            'location' => 'Bandung',
            'job_type' => 'freelance',
            'period' => '2023',
            'description' => 'Melakukan riset dan menyusun Research Organizer menggunakan FigJam sesuai dengan masalah yang diangkat, serta memanfaatkan Figma untuk seluruh proses desain, mulai dari pembuatan wireframe, pengembangan design system, hingga pembuatan prototype. Berkolaborasi secara aktif dengan klien melalui presentasi desain dan revisi visual untuk memastikan hasil akhir sesuai dengan kebutuhan dan ekspektasi.',
            'sort_order' => 2,
        ]);
        Experience::create([
            'title' => 'UI/UX Designer - Internship at Bina Bola',
            'company' => 'Bina Bola',
            'location' => 'Bandung',
            'job_type' => 'internship',
            'period' => '2024',
            'description' => 'Melakukan riset pengguna menggunakan FigJam, serta mendesain antarmuka aplikasi mobile mulai dari pembuatan wireframe, pengembangan design system, hingga pembuatan prototype. Selanjutnya, menguji dan menyempurnakan desain berdasarkan masukan dari tim dan mentor untuk memastikan pengalaman pengguna yang optimal.',
            'sort_order' => 3,
        ]);
        Experience::create([
            'title' => 'UI/UX Designer - Internship at Lembang Agri',
            'company' => 'Lembang Agri',
            'location' => 'Lembang',
            'job_type' => 'internship',
            'period' => '2024 - 2025',
            'description' => 'Berperan sebagai Frontend Mobile dan Frontend Web dari sisi UI/UX Designer dalam proyek hibah fakultas untuk sistem monitoring suhu dan kelembaban greenhouse di Lembang Agri. Mendesain aplikasi mobile agar pengguna dapat memantau data sensor secara real-time, sekaligus berkolaborasi dengan tim developer untuk menghasilkan aplikasi yang fungsional, intuitif, dan mudah digunakan.',
            'sort_order' => 4,
        ]);

        // Projects
        $projects = [
            ['title' => 'TANGGAP', 'subtitle' => 'Platform Pengaduan Masyarakat', 'description' => 'Aplikasi mobile untuk melaporkan permasalahan publik secara cepat, dengan pemantauan status dan komunikasi dua arah.', 'thumbnail' => 'img/tanggap2.png', 'slug' => 'tanggap', 'type' => 'ux', 'is_active' => true, 'sort_order' => 1],
            ['title' => 'PANTAU', 'subtitle' => 'Prediksi Harga Cabai Rawit', 'description' => 'Platform web berbasis machine learning untuk prediksi harga cabai rawit dan analisis tren pasar pertanian.', 'thumbnail' => 'img/pantau3.png', 'slug' => 'pantau', 'type' => 'data_analyst', 'is_active' => true, 'sort_order' => 2],
            ['title' => 'BINA BOLA', 'subtitle' => 'Aplikasi Latihan Sepak Bola Remaja', 'description' => 'Aplikasi mobile untuk pemain muda dengan latihan terstruktur, pelacakan performa, dan pemantauan pelatih.', 'thumbnail' => 'img/binabola2.png', 'slug' => 'binbol', 'type' => 'ux', 'is_active' => true, 'sort_order' => 3],
            ['title' => 'SIAGA', 'subtitle' => 'Aplikasi Notifikasi Gempa & SOS', 'description' => 'Notifikasi gempa real-time dan sinyal SOS darurat untuk respons cepat dalam situasi bencana.', 'thumbnail' => 'img/siaga2.png', 'slug' => 'siaga', 'type' => 'ux', 'is_active' => true, 'sort_order' => 4],
            ['title' => 'GO-MRT', 'subtitle' => 'Aplikasi Transportasi MRT', 'description' => 'Aplikasi untuk memudahkan akses dan informasi transportasi MRT.', 'thumbnail' => 'img/go-mrt.png', 'slug' => 'go-mrt', 'type' => 'ux', 'is_active' => false, 'sort_order' => 5],
            ['title' => 'LEMBANG AGRI', 'subtitle' => 'Sistem Monitoring Greenhouse', 'description' => 'Aplikasi monitoring suhu dan kelembaban greenhouse berbasis IoT.', 'thumbnail' => 'img/lembang.png', 'slug' => 'lembang-agri', 'type' => 'ux', 'is_active' => false, 'sort_order' => 6],
        ];
        foreach ($projects as $p) {
            Project::create($p);
        }

        // Case Studies
        $tanggapCs = CaseStudy::create([
            'project_id' => 1,
            'tagline' => 'Menghubungkan masyarakat dan pemerintah melalui sistem pelaporan yang transparan',
            'duration' => '3 Month',
            'role' => 'UI/UX Designer',
            'tools' => 'Figma',
            'layout' => 'ux',
            'figma_prototype_url' => 'https://www.figma.com/proto/0ilvG9jkraRtirwzHGqN5p/Tanggap-Prototype?node-id=40-1323&viewport=339%2C160%2C0.09&t=kTbbbBqsHz77Z4ls-1&scaling=scale-down&content-scaling=fixed&starting-point-node-id=40%3A1312&page-id=5%3A3',
            'figma_lofi_url' => 'https://www.figma.com/design/0ilvG9jkraRtirwzHGqN5p/Tanggap-Prototype?node-id=507-3509&t=P5jblxyYh4iMKPzR-1',
            'background' => 'Tanggap adalah platform pengaduan masyarakat berbasis mobile yang dirancang untuk membantu warga melaporkan berbagai permasalahan di lingkungan sekitar, seperti kerusakan infrastruktur, masalah sampah, dan gangguan fasilitas umum. Platform ini berfokus pada penyediaan saluran komunikasi yang lebih terstruktur dan transparan antara masyarakat dan pemerintah daerah.',
            'problem' => 'Masyarakat sering mengalami kesulitan dalam melaporkan permasalahan publik karena proses yang tidak jelas, kurangnya umpan balik, serta saluran komunikasi yang tidak terstruktur. Banyak laporan yang tidak ditindaklanjuti, dan pengguna jarang mendapatkan pembaruan status, sehingga menimbulkan frustrasi dan menurunkan kepercayaan terhadap layanan pemerintah.',
            'goal' => 'Tujuan dari proyek ini adalah merancang sistem pelaporan yang intuitif dan mudah diakses, sehingga pengguna dapat dengan mudah mengirim pengaduan, melacak status laporan, serta menerima pembaruan secara real-time. Dengan meningkatkan transparansi dan kemudahan penggunaan, platform ini diharapkan dapat mendorong partisipasi masyarakat dan memperkuat kepercayaan terhadap layanan pemerintah.',
        ]);

        CaseStudySection::create([
            'case_study_id' => $tanggapCs->id, 'type' => 'empathize', 'sort_order' => 1,
            'content' => [
                'research_context' => 'Untuk memahami bagaimana masyarakat melaporkan permasalahan publik dan berinteraksi dengan sistem pengaduan yang ada, saya melakukan penelitian pengguna yang berfokus pada pengalaman pelaporan di kehidupan nyata. Penelitian ini mengeksplorasi bagaimana masyarakat merespons isu seperti kerusakan jalan, masalah sampah, dan gangguan layanan publik, serta ekspektasi mereka terhadap platform pelaporan digital.',
                'method' => 'Wawancara kualitatif dengan 5 partisipan yang pernah melaporkan permasalahan publik. Fokus pada perilaku pelaporan, kendala yang dihadapi, serta ekspektasi terhadap sistem pelaporan yang lebih efektif.',
                'user_types' => [
                    ['title' => 'PELAPOR AKTIF', 'description' => 'Pengguna yang memiliki inisiatif untuk melaporkan permasalahan ketika menemui isu di lingkungan sekitar.', 'behaviors' => ['Menggunakan grup WhatsApp atau media sosial untuk melaporkan masalah', 'Mencoba berbagai saluran agar laporan lebih diperhatikan', 'Mengharapkan respons yang cepat dan jelas dari pihak berwenang']],
                    ['title' => 'PELAPOR PASIF', 'description' => 'Pengguna yang memilih tidak melaporkan permasalahan karena rendahnya kepercayaan terhadap sistem.', 'behaviors' => ['Sering mengabaikan masalah daripada melaporkannya', 'Percaya bahwa laporan tidak akan menghasilkan tindakan nyata', 'Lebih memilih komunikasi informal di lingkungan sekitar']],
                ],
                'pain_points' => ['Tidak ada kejelasan status atau progres setelah laporan dikirim', 'Kurangnya transparansi dalam proses penanganan laporan', 'Ketidakpastian apakah laporan diterima atau diabaikan', 'Saluran pelaporan yang tersebar (media sosial, chat, sistem manual)', 'Tidak adanya umpan balik atau pembaruan penyelesaian yang terstruktur'],
                'insight' => 'Permasalahan utama bukan terletak pada rendahnya keinginan masyarakat untuk melaporkan, melainkan kurangnya transparansi dan umpan balik setelah laporan dikirim. Tanpa visibilitas terhadap proses penanganan, pengguna kehilangan kepercayaan dan menjadi enggan menggunakan sistem pelaporan formal.',
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $tanggapCs->id, 'type' => 'define', 'sort_order' => 2,
            'content' => [
                'summary' => 'Insight dari tahap Empathize menunjukkan bahwa masyarakat memiliki kemauan untuk melaporkan permasalahan publik, namun pengalaman mereka terhambat oleh kurangnya transparansi dan umpan balik. Proses pelaporan saat ini belum memberikan kejelasan mengenai apa yang terjadi setelah laporan dikirim.',
                'insight' => 'Motivasi pengguna bukanlah masalah utama—melainkan kepercayaan. Ketika pengguna tidak menerima pembaruan atau konfirmasi, mereka cenderung menganggap laporan mereka diabaikan. Seiring waktu, hal ini menurunkan keterlibatan dan mendorong pengguna beralih ke saluran informal yang dianggap lebih responsif.',
                'persona' => ['name' => 'RADEN NURALIF – WARGA YANG PEDULI', 'description' => 'Raden Nuralif adalah seorang mahasiswa yang tinggal di Bandung. Ia pernah menemukan masalah kabel listrik yang berbahaya di lingkungannya dan memutuskan untuk melaporkannya melalui platform pengaduan online.', 'detail' => 'Setelah mengirim laporan, ia tidak menerima respons maupun pembaruan. Kurangnya umpan balik membuatnya merasa sistem tidak efektif.', 'expectation' => 'Sistem pengaduan yang memberikan respons yang jelas, proses yang transparan, serta penyelesaian yang lebih cepat.', 'image' => 'tanggap/persona.png'],
                'problem_statement' => 'Masyarakat membutuhkan sistem pengaduan yang menyediakan pelacakan status yang jelas, komunikasi yang transparan, serta umpan balik yang berkelanjutan, sehingga mereka merasa yakin bahwa laporan mereka diterima dan sedang ditindaklanjuti.',
                'how_might_we' => 'Bagaimana kita dapat merancang sistem pelaporan yang transparan, memberikan informasi status secara berkelanjutan, dan mampu membangun kembali kepercayaan pengguna terhadap layanan publik?',
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $tanggapCs->id, 'type' => 'ideate', 'sort_order' => 3,
            'content' => [
                'direction' => 'Berdasarkan permasalahan yang telah dirumuskan, solusi difokuskan pada pengembangan sistem pengaduan yang transparan dan mudah digunakan. Sistem ini memungkinkan masyarakat untuk melaporkan masalah dengan mudah, melacak progres penanganan, serta menerima pembaruan secara berkelanjutan. Tujuannya adalah meningkatkan kepercayaan pengguna dengan menghadirkan proses pelaporan yang lebih terlihat, terstruktur, dan responsif.',
                'features' => [
                    ['title' => 'PENGIRIMAN LAPORAN', 'description' => 'Alur pelaporan yang sederhana dan terarah untuk memudahkan pengguna mengirim laporan dengan cepat.', 'functions' => ['Mengirim laporan dengan foto dan deskripsi', 'Deteksi lokasi otomatis', 'Pemilihan kategori untuk pelaporan yang lebih terstruktur']],
                    ['title' => 'PELACAKAN STATUS REAL-TIME', 'description' => 'Sistem pelacakan transparan yang membantu pengguna mengetahui status laporan secara berkala.', 'functions' => ['Pembaruan status (dikirim, diproses, selesai)', 'Tampilan timeline progres laporan', 'Notifikasi untuk setiap pembaruan']],
                    ['title' => 'KOMUNIKASI DUA ARAH', 'description' => 'Memungkinkan interaksi antara pengguna dan pihak berwenang untuk mengurangi ketidakpastian.', 'functions' => ['Balasan atau tanggapan dari pihak berwenang', 'Permintaan informasi tambahan dari pengguna', 'Konfirmasi yang jelas saat laporan diterima']],
                    ['title' => 'RIWAYAT LAPORAN & DASHBOARD', 'description' => 'Tempat terpusat bagi pengguna untuk memantau seluruh laporan yang telah dikirim.', 'functions' => ['Daftar laporan yang telah dikirim', 'Filter berdasarkan status atau kategori', 'Ringkasan laporan yang sudah selesai dan yang masih diproses']],
                ],
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $tanggapCs->id, 'type' => 'prototype', 'sort_order' => 4,
            'content' => [
                'description' => 'Prototipe dengan tingkat fidelitas rendah hingga tinggi dikembangkan untuk memvalidasi usability, alur navigasi, serta kejelasan proses pelaporan.',
                'lofi_images' => ['tanggap/lofi1.png', 'tanggap/lofi2.png'],
                'hifi_images' => ['tanggap/splash.png', 'tanggap/login.png', 'tanggap/home.png', 'tanggap/pengaduan1.png', 'tanggap/pengaduan2.png', 'tanggap/chatbot1.png', 'tanggap/pantau.png', 'tanggap/berita.png', 'tanggap/pengaduan3.png', 'tanggap/chatbot2.png'],
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $tanggapCs->id, 'type' => 'test', 'sort_order' => 5,
            'content' => [
                'description' => 'Pengujian usability dilakukan untuk mengevaluasi bagaimana pengguna berinteraksi dengan prototipe, dengan fokus pada kejelasan alur pelaporan, kemudahan navigasi, serta visibilitas pelacakan status.',
                'method' => 'Usability testing terarah (moderated) dengan 5 partisipan yang memiliki pengalaman dalam melaporkan permasalahan publik. Skenario berbasis tugas (task-based).',
                'tasks' => ['Mengirim laporan dengan foto dan deskripsi', 'Memeriksa status dan progres laporan', 'Melihat riwayat laporan', 'Menavigasi antar fitur utama'],
                'findings' => ['Pengguna dapat menyelesaikan proses pelaporan dengan mudah tanpa bantuan', 'Layout yang sederhana membantu pengguna memahami alur dengan cepat', 'Beberapa pengguna awalnya kesulitan menemukan fitur status laporan', 'Pengguna mengharapkan umpan balik yang lebih jelas setelah mengirim laporan'],
                'insight' => 'Meskipun alur pelaporan sudah cukup intuitif, visibilitas dan umpan balik tetap menjadi faktor krusial. Pengguna membutuhkan konfirmasi yang jelas serta akses yang mudah terhadap status laporan agar merasa yakin bahwa laporan mereka sedang diproses.',
                'iteration' => 'Berdasarkan hasil pengujian, dilakukan perbaikan dengan meningkatkan visibilitas fitur status laporan, menambahkan umpan balik yang lebih jelas setelah pengiriman, serta memperbaiki petunjuk navigasi agar pengguna lebih mudah memahami alur penggunaan.',
            ],
        ]);

        // BINA BOLA case study
        $binbolCs = CaseStudy::create([
            'project_id' => 3,
            'tagline' => 'Mendukung perkembangan pemain muda melalui latihan terstruktur dan pemantauan performa',
            'duration' => '3 Month',
            'role' => 'UI/UX Designer',
            'tools' => 'Figma',
            'layout' => 'ux',
            'figma_prototype_url' => 'https://www.figma.com/proto/jOCE4WlOFlMdEIs46oMPZn/Bina-Bola?node-id=2-4&viewport=77%2C185%2C0.43&t=HfyYYq7ixROHI7X0-1&scaling=scale-down&content-scaling=fixed&starting-point-node-id=1%3A2&show-proto-sidebar=1&page-id=0%3A1',
            'figma_lofi_url' => 'https://www.figma.com/design/xEDXItFvmDWNHLDWoWpRj6/PROJECT-LOFI?node-id=0-1&t=Yvz9DEY1w2D6ZNq7-1',
            'background' => 'Bina Bola adalah aplikasi mobile yang dirancang untuk membantu pemain muda meningkatkan kemampuan sepak bola melalui latihan terstruktur, sesi interaktif, dan pelacakan performa. Aplikasi ini juga memungkinkan pelatih dan orang tua untuk memantau perkembangan pemain serta memberikan umpan balik secara berkelanjutan.',
            'problem' => 'Pemain muda sering kesulitan dalam mengembangkan kemampuan secara konsisten karena kurangnya panduan latihan yang terstruktur serta minimnya pemantauan perkembangan. Di sisi lain, pelatih dan orang tua juga mengalami keterbatasan dalam memonitor progres dan memberikan umpan balik yang tepat secara berkelanjutan.',
            'goal' => 'Proyek ini bertujuan untuk merancang aplikasi yang intuitif dan mudah digunakan, yang membantu pemain muda menjalani latihan secara terarah, memantau perkembangan performa, serta memungkinkan pelatih dan orang tua memberikan dukungan dan evaluasi secara efektif.',
        ]);

        CaseStudySection::create([
            'case_study_id' => $binbolCs->id, 'type' => 'empathize', 'sort_order' => 1,
            'content' => [
                'research_context' => 'Untuk memahami bagaimana pemain muda berlatih dan mengembangkan kemampuan sepak bola, dilakukan penelitian pengguna yang berfokus pada pengalaman latihan sehari-hari.',
                'method' => 'Wawancara kualitatif dengan 5 partisipan yang terdiri dari pemain muda, pelatih, dan orang tua.',
                'user_types' => [
                    ['title' => 'PEMAIN AKTIF', 'description' => 'Pemain yang memiliki motivasi tinggi untuk berlatih dan meningkatkan kemampuan secara mandiri.', 'behaviors' => ['Berlatih secara rutin di luar sesi latihan formal', 'Mencari referensi latihan melalui video atau media sosial', 'Ingin mengetahui perkembangan kemampuan secara terukur']],
                    ['title' => 'PEMAIN PASIF', 'description' => 'Pemain yang kurang konsisten dalam berlatih karena minimnya arahan dan motivasi.', 'behaviors' => ['Hanya berlatih saat ada sesi latihan dari pelatih', 'Tidak memiliki panduan latihan yang jelas', 'Kurang mengetahui perkembangan kemampuan diri']],
                ],
                'pain_points' => ['Tidak adanya panduan latihan yang terstruktur dan mudah diikuti', 'Kesulitan dalam memantau perkembangan kemampuan secara konsisten', 'Kurangnya umpan balik dari pelatih terhadap performa pemain', 'Tidak adanya sistem terpusat untuk mengelola latihan dan progres', 'Minimnya keterlibatan orang tua dalam memantau perkembangan pemain'],
                'insight' => 'Permasalahan utama bukan terletak pada kurangnya keinginan pemain untuk berkembang, tetapi pada kurangnya struktur, pemantauan, dan umpan balik dalam proses latihan.',
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $binbolCs->id, 'type' => 'define', 'sort_order' => 2,
            'content' => [
                'summary' => 'Insight dari tahap Empathize menunjukkan bahwa pemain memiliki motivasi tinggi untuk berkembang. Namun, proses latihan yang belum terstruktur, kurangnya pemantauan performa, serta minimnya umpan balik membuat latihan menjadi kurang optimal.',
                'insight' => 'Permasalahan utama bukan terletak pada motivasi pemain, melainkan pada belum adanya sistem yang mendukung latihan secara terarah dan terukur.',
                'persona' => ['name' => 'POR UNI – TIM SSB YANG BERKEMBANG', 'description' => 'POR UNI merupakan Sekolah Sepak Bola (SSB) yang berfokus pada pengembangan pemain usia dini hingga remaja.', 'detail' => 'Pelatih masih mengandalkan observasi langsung tanpa dukungan sistem pencatatan performa. Pemain kesulitan melakukan latihan mandiri karena tidak memiliki panduan yang jelas.', 'expectation' => 'Sistem yang mampu menyediakan latihan terstruktur, pelacakan performa yang jelas, serta memfasilitasi umpan balik berkelanjutan.', 'image' => 'binbol/persona.png'],
                'problem_statement' => 'Tim SSB membutuhkan sistem latihan yang terstruktur, mudah diterapkan, dan memiliki pelacakan performa yang jelas.',
                'how_might_we' => 'Bagaimana kita dapat merancang aplikasi latihan sepak bola yang terstruktur, memungkinkan pelacakan performa secara jelas, serta mendukung umpan balik berkelanjutan antara pelatih, pemain, dan orang tua?',
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $binbolCs->id, 'type' => 'ideate', 'sort_order' => 3,
            'content' => [
                'direction' => 'Solusi difokuskan pada perancangan aplikasi latihan sepak bola yang terstruktur, mudah digunakan, dan mampu mendukung perkembangan pemain secara berkelanjutan.',
                'features' => [
                    ['title' => 'PROGRAM LATIHAN TERSTRUKTUR', 'description' => 'Menyediakan panduan latihan yang sistematis agar pemain dapat berlatih secara terarah.', 'functions' => ['Daftar latihan berdasarkan level dan tujuan', 'Panduan langkah demi langkah untuk setiap latihan', 'Konten visual seperti video atau ilustrasi latihan']],
                    ['title' => 'REAL TIME STATUS TRACKING', 'description' => 'Sistem pelacakan real-time untuk memantau progres latihan pemain.', 'functions' => ['Pembaruan status latihan', 'Tampilan timeline progres', 'Notifikasi untuk setiap pembaruan']],
                    ['title' => 'PELACAKAN PERFORMA', 'description' => 'Membantu pemain memantau perkembangan kemampuan secara terukur dan berkelanjutan.', 'functions' => ['Pencatatan hasil latihan dan progres', 'Visualisasi perkembangan performa', 'Target latihan yang dapat dicapai']],
                    ['title' => 'UMPAN BALIK PELATIH', 'description' => 'Memungkinkan pelatih memberikan evaluasi dan arahan secara langsung kepada pemain.', 'functions' => ['Pelatih dapat memberikan komentar pada hasil latihan', 'Evaluasi performa pemain secara berkala', 'Saran peningkatan teknik dan kemampuan']],
                ],
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $binbolCs->id, 'type' => 'prototype', 'sort_order' => 4,
            'content' => [
                'description' => 'Prototipe dengan tingkat fidelitas rendah hingga tinggi dikembangkan untuk menguji usability, alur navigasi, serta kejelasan pengalaman latihan.',
                'lofi_images' => ['binbol/lofi1.png', 'binbol/lofi2.png'],
                'hifi_images' => ['binbol/login.png', 'binbol/home.png', 'binbol/modul.png', 'binbol/teknik.png', 'binbol/ball feeling.png', 'binbol/fisik.png', 'binbol/sit up.png', 'binbol/strategi.png', 'binbol/menyerang.png', 'binbol/live score.png'],
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $binbolCs->id, 'type' => 'test', 'sort_order' => 5,
            'content' => [
                'description' => 'Pengujian usability dilakukan untuk mengevaluasi bagaimana pengguna berinteraksi dengan prototipe.',
                'method' => 'Usability testing terarah dengan 5 partisipan yang memiliki pengalaman dalam latihan sepak bola.',
                'tasks' => ['Mengakses dan mengikuti program latihan', 'Melihat detail latihan dan instruksi', 'Memeriksa progres dan pelacakan performa', 'Menavigasi antar fitur utama aplikasi'],
                'findings' => ['Pengguna dapat memahami alur latihan dengan mudah', 'Struktur UI yang sederhana membantu mempercepat pemahaman sistem', 'Beberapa pengguna awalnya kurang menyadari fitur pelacakan performa', 'Pengguna mengharapkan umpan balik atau indikator progres yang lebih jelas'],
                'insight' => 'Meskipun alur latihan sudah cukup intuitif, visibilitas progres dan umpan balik tetap menjadi faktor penting.',
                'iteration' => 'Berdasarkan hasil pengujian, dilakukan peningkatan pada visibilitas fitur pelacakan performa dan penambahan indikator progres yang lebih jelas.',
            ],
        ]);

        // SIAGA case study
        $siagaCs = CaseStudy::create([
            'project_id' => 4,
            'tagline' => 'Memberdayakan komunitas melalui kesiapsiagaan dan respons terhadap gempa bumi',
            'duration' => '3 Month',
            'role' => 'UI/UX Designer',
            'tools' => 'Figma',
            'layout' => 'ux',
            'figma_prototype_url' => 'https://www.figma.com/proto/7xyEOCMSFfBGuSrqteigQa/Siaga?node-id=589-2010&viewport=884%2C361%2C0.24&t=y0qT6Q2oQova0h3s-1&scaling=scale-down&content-scaling=fixed&starting-point-node-id=12%3A26&show-proto-sidebar=1&page-id=2%3A2',
            'figma_lofi_url' => 'https://www.figma.com/design/7xyEOCMSFfBGuSrqteigQa/Siaga?node-id=661-4778&t=JcEFuJweW7IiJqb0-1',
            'background' => 'Aplikasi Siaga Gempa dirancang sebagai platform mobile untuk memberikan informasi dan peringatan gempa bumi secara real-time kepada pengguna. Selain itu, aplikasi ini juga menyediakan fitur SOS yang memungkinkan pengguna mengirimkan sinyal darurat saat terjadi bencana.',
            'problem' => 'Banyak masyarakat tidak mendapatkan informasi gempa secara cepat dan akurat, sehingga respon terhadap situasi darurat menjadi terlambat. Selain itu, kurangnya sistem yang terintegrasi untuk meminta bantuan saat kondisi darurat membuat penanganan korban menjadi kurang efisien.',
            'goal' => 'Proyek ini bertujuan untuk menyediakan sistem peringatan gempa yang cepat, akurat, dan mudah diakses, serta mempermudah pengguna dalam mengirimkan sinyal darurat (SOS) agar bantuan dapat segera diberikan dalam situasi kritis.',
        ]);

        CaseStudySection::create([
            'case_study_id' => $siagaCs->id, 'type' => 'empathize', 'sort_order' => 1,
            'content' => [
                'research_context' => 'Untuk memahami bagaimana pengguna menerima dan merespons peringatan gempa bumi serta penggunaan fitur darurat, dilakukan penelitian pengguna.',
                'method' => 'Wawancara kualitatif dengan 5 partisipan yang pernah mengalami atau merasakan gempa bumi.',
                'user_types' => [
                    ['title' => 'PENGGUNA SIAGA AKTIF', 'description' => 'Pengguna yang responsif terhadap situasi darurat.', 'behaviors' => ['Segera merespons notifikasi gempa atau peringatan darurat', 'Menggunakan fitur SOS saat berada dalam situasi berbahaya', 'Mencari informasi tambahan melalui berbagai sumber']],
                    ['title' => 'PENGGUNA SIAGA PASIF', 'description' => 'Pengguna yang cenderung kurang responsif terhadap peringatan gempa.', 'behaviors' => ['Sering mengabaikan notifikasi peringatan gempa', 'Jarang menggunakan fitur SOS meskipun dalam kondisi darurat', 'Mengandalkan informasi dari orang sekitar dibanding sistem aplikasi']],
                ],
                'pain_points' => ['Tidak ada kejelasan status setelah pengguna mengirim laporan', 'Kurangnya transparansi dalam proses penanganan laporan', 'Pengguna tidak tahu apakah laporan sudah diterima atau diabaikan', 'Saluran pelaporan yang terpecah-pecah', 'Tidak ada pembaruan atau umpan balik terkait penyelesaian laporan'],
                'insight' => 'Masalah utama bukan pada kemauan pengguna untuk melaporkan kejadian, tetapi pada kurangnya transparansi dan umpan balik setelah laporan dikirim.',
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $siagaCs->id, 'type' => 'define', 'sort_order' => 2,
            'content' => [
                'summary' => 'Dari penelitian pada tahap Empathize, ditemukan bahwa pengguna sangat membutuhkan sistem peringatan gempa yang cepat dan dapat diandalkan.',
                'insight' => 'Pengguna ingin segera mendapatkan peringatan saat gempa terjadi, tetapi kepercayaan mereka menurun ketika informasi terlambat atau tidak jelas.',
                'persona' => ['name' => 'JUNIOR – PENGGUNA PEDULI SIAGA', 'description' => 'Junior adalah seorang pekerja kantoran berusia 28 tahun yang tinggal di daerah perkotaan Bandung.', 'detail' => 'Ketika terjadi gempa, Junior biasanya segera mencari informasi tambahan. Namun pengalaman sebelumnya membuatnya sering merasa cemas karena informasi tidak selalu jelas atau datang terlambat.', 'expectation' => 'Informasi real-time dan panduan yang jelas saat bencana.', 'image' => 'siaga/persona.png'],
                'problem_statement' => 'Pengguna membutuhkan sistem peringatan gempa yang terpusat dan andal yang dapat memberikan notifikasi real-time.',
                'how_might_we' => 'Bagaimana jika kita merancang sistem peringatan gempa yang mampu memberikan notifikasi real-time secara akurat, membantu pengguna memahami kondisi darurat dengan cepat?',
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $siagaCs->id, 'type' => 'ideate', 'sort_order' => 3,
            'content' => [
                'direction' => 'Solusi berfokus pada pengembangan aplikasi darurat gempa bumi yang meningkatkan keselamatan pengguna melalui notifikasi gempa secara real-time, fitur SOS darurat yang cepat diakses.',
                'features' => [
                    ['title' => 'SOS DARURAT & WIDGET', 'description' => 'Sistem sinyal darurat cepat yang dirancang untuk situasi gempa bumi kritis.', 'functions' => ['Mengirim sinyal SOS secara instan saat terjadi gempa', 'Mengaktifkan peringatan darurat ke pengguna di sekitar', 'Akses SOS melalui widget tanpa perlu membuka aplikasi']],
                    ['title' => 'PERINGATAN GEMPA BUMI', 'description' => 'Sistem notifikasi real-time yang memberikan informasi gempa bumi secara cepat.', 'functions' => ['Peringatan gempa bumi secara real-time', 'Mode peringatan darurat layar penuh', 'Sistem notifikasi suara dan getaran']],
                    ['title' => 'MAP, EDUKASI & DONASI', 'description' => 'Fitur pendukung untuk meningkatkan kesadaran dan kesiapsiagaan.', 'functions' => ['Peta interaktif riwayat gempa bumi', 'Artikel edukasi & video terkait mitigasi bencana', 'Sistem pelacakan donasi yang transparan']],
                ],
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $siagaCs->id, 'type' => 'prototype', 'sort_order' => 4,
            'content' => [
                'description' => 'Prototipe dari tingkat low hingga high fidelity dibuat untuk menguji kegunaan dan alur navigasi.',
                'lofi_images' => ['siaga/lofi1.png', 'siaga/lofi2.png'],
                'hifi_images' => ['siaga/splash.png', 'siaga/login.png', 'siaga/Home.png', 'siaga/sos.png', 'siaga/call.png', 'siaga/edukasi.png', 'siaga/donasi.png', 'siaga/video.png', 'siaga/alert.png', 'siaga/riwayat.png'],
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $siagaCs->id, 'type' => 'test', 'sort_order' => 5,
            'content' => [
                'description' => 'Pengujian usability dilakukan untuk mengevaluasi keberhasilan penyelesaian tugas dan kejelasan navigasi.',
                'method' => 'Pengujian usability yang dimoderasi dengan 5 partisipan yang memiliki pengalaman dalam situasi darurat.',
                'tasks' => ['Mengirim laporan darurat', 'Memeriksa status laporan', 'Mengakses fitur darurat (SOS / Panggilan bantuan)', 'Menavigasi ke bagian edukasi dan donasi'],
                'findings' => ['Pengguna dapat menyelesaikan alur penggunaan lebih cepat', 'Navigasi menjadi lebih jelas karena struktur layout yang disederhanakan', 'Beberapa pengguna awalnya tidak menyadari adanya bagian "status darurat"', 'Fitur darurat dinilai sangat berguna dan mudah diakses'],
                'insight' => 'Prototipe berhasil meningkatkan efisiensi dan kejelasan alur penggunaan aplikasi.',
                'iteration' => 'Desain disempurnakan dengan meningkatkan keterlihatan fitur pelacakan laporan darurat.',
            ],
        ]);

        // PANTAU case study
        $pantauCs = CaseStudy::create([
            'project_id' => 2,
            'tagline' => 'Machine Learning Forecasting menggunakan XGBoost dengan Feature Engineering berbasis Time Series',
            'duration' => '3 Bulan',
            'role' => 'Data Analyst',
            'tools' => 'Python · XGBoost · Pandas',
            'layout' => 'data',
            'hero_bg' => 'pantau/banner1.jpg',
            'background' => 'Pantau.id adalah inisiatif digital berbasis Machine Learning dan data real-time yang dirancang untuk membantu petani, pedagang, dan pengambil kebijakan memahami, mengantisipasi, dan mengatasi fluktuasi harga cabai rawit di Kota Bandung.',
            'footer_description' => 'Platform peramalan harga cabai rawit berbasis data real-time, cuaca, dan tren pasar. Bantu petani, pedagang, dan pengambil kebijakan membuat keputusan lebih cerdas.',
        ]);

        CaseStudySection::create([
            'case_study_id' => $pantauCs->id, 'type' => 'data_sources', 'sort_order' => 1,
            'content' => [
                'title' => 'Sumber Data Model Prediksi',
                'description' => 'Model XGBoost ini dibangun menggunakan kombinasi data cuaca dan data harga pasar untuk menghasilkan prediksi yang lebih akurat dan realistis.',
                'weather_data' => ['indicators' => ['Suhu (Temperature)', 'Kelembapan (Humidity)', 'Curah Hujan (Rainfall)'], 'source' => 'BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)'],
                'price_data' => ['indicators' => ['Harga Produsen', 'Harga Pengepul', 'Harga Pasar'], 'source' => 'PIHPS (Pusat Informasi Harga Pangan Strategis – Bank Indonesia)'],
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $pantauCs->id, 'type' => 'feature_engineering', 'sort_order' => 2,
            'content' => [
                'title' => 'Feature Engineering — Menjembatani Time Series & Machine Learning',
                'background_model' => 'XGBoost bukan model time series native. Model ini tidak memahami urutan waktu secara langsung seperti ARIMA atau LSTM.',
                'challenge' => 'Data harga cabai rawit memiliki karakteristik time series seperti tren, musiman, dan efek kejadian eksternal.',
                'features' => [
                    ['title' => 'Lag Features', 'description' => 'Menggunakan nilai historis (t-1, t-7, t-30) untuk menangkap pengaruh harga sebelumnya terhadap harga saat ini.'],
                    ['title' => 'Moving Average', 'description' => 'Rata-rata harga dalam periode tertentu untuk mengurangi noise dan menangkap tren jangka pendek.'],
                    ['title' => 'Seasonal Pattern', 'description' => 'Menangkap pola musiman berdasarkan minggu, bulan, dan siklus tertentu dalam data harga.'],
                    ['title' => 'Event Features', 'description' => 'Mengukur dampak hari besar dan jarak menuju hari besar terhadap fluktuasi harga pasar.'],
                ],
                'insight' => 'Dengan feature engineering ini, data time series diubah menjadi bentuk tabular yang dapat dipahami XGBoost.',
            ],
        ]);

        CaseStudySection::create([
            'case_study_id' => $pantauCs->id, 'type' => 'model_performance', 'sort_order' => 3,
            'content' => [
                'title' => 'Model Performance',
                'subtitle' => 'Evaluasi performa model XGBoost dalam memprediksi harga cabai rawit',
                'metrics' => [
                    ['label' => 'MAE', 'value' => '1921', 'description' => 'Mean Absolute Error'],
                    ['label' => 'RMSE', 'value' => '2672', 'description' => 'Root Mean Square Error'],
                    ['label' => 'MAPE', 'value' => '2.96%', 'description' => 'Mean Absolute Percentage Error'],
                    ['label' => 'R²', 'value' => '0.95', 'description' => 'R-Squared'],
                ],
                'chart_image' => 'pantau/chart.png',
                'chart_insight' => 'Hasil evaluasi menunjukkan bahwa model XGBoost mampu mengikuti pola fluktuasi harga dengan cukup baik. Prediksi memiliki tren yang selaras dengan data aktual, terutama dalam menangkap kenaikan dan penurunan harga secara periodik.',
                'key_insight' => 'XGBoost dengan feature engineering mampu menangkap pola harga dengan cukup baik, terutama pada tren stabil. Namun performa menurun pada kondisi harga yang sangat fluktif.',
            ],
        ]);
    }
}
