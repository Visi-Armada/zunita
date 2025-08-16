<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
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

        $pages = [
            [
                'title' => 'Tentang YB Dato\' Zunita Begum',
                'slug' => 'tentang',
                'meta_description' => 'Maklumat lengkap tentang YB Dato\' Zunita Begum, Ahli Dewan Undangan Negeri Pilah',
                'content' => '<h2>Latar Belakang</h2><p>YB Dato\' Zunita Begum adalah Ahli Dewan Undangan Negeri Pilah yang komited kepada pembangunan komuniti dan transparensi dalam pengurusan dana awam.</p><h2>Visi & Misi</h2><p>Beliau bertekad untuk membawa perubahan positif kepada masyarakat melalui inisiatif yang berkesan dan akauntabiliti yang tinggi.</p>',
                'template' => 'default',
                'status' => 'published',
                'is_featured' => true,
                'order' => 1,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Program Bantuan Masyarakat',
                'slug' => 'program-bantuan',
                'meta_description' => 'Senarai program bantuan yang disediakan untuk masyarakat di kawasan Pilah',
                'content' => '<h2>Program Bantuan Pendidikan</h2><p>Bantuan kewangan untuk pelajar miskin di kawasan Pilah.</p><h2>Program Kesihatan</h2><p>Pemeriksaan kesihatan percuma untuk warga emas dan keluarga berpendapatan rendah.</p>',
                'template' => 'default',
                'status' => 'published',
                'is_featured' => false,
                'order' => 2,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'Hubungi Kami',
                'slug' => 'hubungi-kami',
                'meta_description' => 'Maklumat hubungan untuk menghubungi pejabat YB Dato\' Zunita Begum',
                'content' => '<h2>Alamat Pejabat</h2><p>Pejabat YB Dato\' Zunita Begum<br>Jalan Besar Pilah<br>72000 Kuala Pilah, Negeri Sembilan</p><h2>Maklumat Hubungan</h2><p>Telefon: 06-481 1234<br>Emel: info@zunitabegum.my</p>',
                'template' => 'contact',
                'status' => 'published',
                'is_featured' => false,
                'order' => 3,
                'user_id' => $adminUser->id,
            ],
            [
                'title' => 'adad',
                'slug' => 'adad',
                'meta_description' => 'Halaman contoh untuk ujian',
                'content' => '<h2>Halaman Contoh</h2><p>Ini adalah halaman contoh yang dibuat untuk tujuan ujian sistem.</p><p>Halaman ini menunjukkan bahawa sistem halaman berfungsi dengan baik.</p>',
                'template' => 'default',
                'status' => 'published',
                'is_featured' => false,
                'order' => 4,
                'user_id' => $adminUser->id,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
