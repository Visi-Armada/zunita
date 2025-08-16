<?php

namespace Database\Seeders;

use App\Models\Carousel;
use App\Models\User;
use Illuminate\Database\Seeder;

class CarouselSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first admin user
        $adminUser = User::first();

        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@zunitabegum.my',
                'password' => bcrypt('password'),
            ]);
        }

        $carousels = [
            [
                'title' => 'Selamat Datang ke Laman Web Rasmi YB Dato\' Zunita Begum',
                'description' => 'Ahli Dewan Undangan Negeri Pilah yang komited kepada transparensi dan pembangunan komuniti',
                'image' => 'carousel/welcome-banner.jpg',
                'alt_text' => 'YB Dato Zunita Begum official website banner',
                'link_url' => '#about',
                'button_text' => 'Ketahui Lebih Lanjut',
                'order' => 1,
                'is_active' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Program Bantuan Pendidikan 2025',
                'description' => 'Bantuan kewangan untuk pelajar miskin di kawasan Pilah. Meliputi yuran sekolah, buku teks, dan peralatan pembelajaran.',
                'image' => 'carousel/education-program.jpg',
                'alt_text' => 'Education assistance program for students',
                'link_url' => '/initiatives',
                'button_text' => 'Mohon Sekarang',
                'order' => 2,
                'is_active' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Inisiatif Kesihatan Komuniti',
                'description' => 'Program pemeriksaan kesihatan percuma untuk warga emas dan keluarga berpendapatan rendah',
                'image' => 'carousel/health-initiative.jpg',
                'alt_text' => 'Community health initiative program',
                'link_url' => '/initiatives',
                'button_text' => 'Lihat Program',
                'order' => 3,
                'is_active' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Pembangunan Infrastruktur Kampung',
                'description' => 'Pembaikan jalan kampung, sistem saliran, dan kemudahan awam di kawasan Pilah',
                'image' => 'carousel/infrastructure.jpg',
                'alt_text' => 'Village infrastructure development',
                'link_url' => '/initiatives',
                'button_text' => 'Lihat Projek',
                'order' => 4,
                'is_active' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Transparensi dalam Pengurusan Dana Awam',
                'description' => 'Setiap ringgit yang diperuntukkan dipantau dan dilaporkan secara terbuka untuk akauntabiliti kepada rakyat',
                'image' => 'carousel/transparency.jpg',
                'alt_text' => 'Public fund management transparency',
                'link_url' => '#statistics',
                'button_text' => 'Lihat Statistik',
                'order' => 5,
                'is_active' => true,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Hubungi Kami',
                'description' => 'Untuk sebarang pertanyaan atau bantuan, sila hubungi pejabat YB Dato\' Zunita Begum',
                'image' => 'carousel/contact.jpg',
                'alt_text' => 'Contact YB Dato Zunita Begum office',
                'link_url' => '/pages/hubungi-kami',
                'button_text' => 'Hubungi Kami',
                'order' => 6,
                'is_active' => true,
                'user_id' => $adminUser->id,
            ],
        ];

        foreach ($carousels as $carouselData) {
            Carousel::updateOrCreate(
                ['title' => $carouselData['title']],
                $carouselData
            );
        }
    }
}
