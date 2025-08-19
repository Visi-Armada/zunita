<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PageContent;
use App\Models\User;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user or create one
        $user = User::first() ?? User::factory()->create();

        $sections = [
            [
                'section_name' => 'carousel',
                'title' => 'Selamat Datang ke Laman Web YB Dato\' Zunita Begum',
                'content' => '<p>Ahli Dewan Undangan Negeri (ADUN) Pilah yang komited untuk membangunkan komuniti dan meningkatkan kualiti hidup rakyat.</p>',
                'images' => ['carousel/welcome-banner.jpg'],
                'settings' => [
                    'autoplay' => true,
                    'interval' => 5000,
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'section_name' => 'statistics',
                'title' => 'Statistik Ketelusan',
                'content' => '<p>Data terkini mengenai sumbangan dan program yang telah dijalankan untuk manfaat rakyat Pilah.</p>',
                'images' => [],
                'settings' => [
                    'show_charts' => true,
                    'update_frequency' => 'monthly',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'section_name' => 'about',
                'title' => 'Tentang YB Dato\' Zunita Begum',
                'content' => '<p>YB Dato\' Zunita Begum adalah Ahli Dewan Undangan Negeri (ADUN) Pilah yang komited untuk membangunkan komuniti dan meningkatkan kualiti hidup rakyat di kawasan Pilah.</p>',
                'images' => [],
                'settings' => [
                    'vision_mission' => '<p><strong>Visi:</strong> Untuk menjadikan Pilah sebagai kawasan yang maju, makmur dan selesa untuk didiami.</p><p><strong>Misi:</strong> Memberikan perkhidmatan terbaik kepada rakyat dan memastikan pembangunan yang seimbang di semua aspek.</p>',
                    'features' => [
                        [
                            'title' => 'Komitmen kepada Rakyat',
                            'description' => 'Sentiasa mendengar dan bertindak atas keperluan rakyat Pilah'
                        ],
                        [
                            'title' => 'Pembangunan Mampan',
                            'description' => 'Memastikan pembangunan yang mesra alam dan berkekalan'
                        ],
                        [
                            'title' => 'Ketelusan',
                            'description' => 'Mengamalkan ketelusan dalam semua urusan dan perbelanjaan'
                        ]
                    ]
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'section_name' => 'initiatives',
                'title' => 'Inisiatif Semasa',
                'content' => '<p>Program dan inisiatif yang sedang dijalankan untuk manfaat rakyat Pilah.</p>',
                'images' => [],
                'settings' => [
                    'show_featured' => true,
                    'max_display' => 6,
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'section_name' => 'contact',
                'title' => 'Hubungi Kami',
                'content' => '<p>Untuk sebarang pertanyaan, aduan atau cadangan, sila hubungi kami melalui maklumat di bawah.</p>',
                'images' => [],
                'settings' => [
                    'address' => 'Pejabat ADUN Pilah\nJalan Besar Pilah\n71600 Pilah\nNegeri Sembilan',
                    'phone' => '+60 6-481 1234',
                    'email' => 'adun.pilah@ns.gov.my',
                    'hours' => 'Isnin - Jumaat: 8:00 AM - 5:00 PM\nSabtu: 8:00 AM - 12:00 PM',
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($sections as $section) {
            PageContent::create(array_merge($section, ['user_id' => $user->id]));
        }
    }
}
