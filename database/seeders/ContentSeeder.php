<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UrgentInfo;
use App\Models\Announcement;
use App\Models\QuickLink;

class ContentSeeder extends Seeder
{
    public function run()
    {
        UrgentInfo::create([
            'title' => 'Informasi Penting',
            'message' => 'Pendaftaran siswa baru tahun ajaran 2023/2024 dibuka mulai 1 Januari 2023.',
            'start_date' => now(),
            'end_date' => now()->addWeeks(2),
            'url' => '#'
        ]);

        Announcement::create([
            'title' => 'Libur Semester Ganjil',
            'content' => 'Libur semester ganjil dimulai dari 18 Desember 2022 hingga 2 Januari 2023.',
            'publish_date' => now(),
            'expired_at' => now()->addMonth()
        ]);

        $quickLinks = [
            ['label' => 'PPDB', 'url' => '#', 'icon' => 'book', 'color' => 'blue'],
            ['label' => 'E-Learning', 'url' => '#', 'icon' => 'monitor', 'color' => 'teal'],
            ['label' => 'Kalender', 'url' => '#', 'icon' => 'calendar', 'color' => 'purple'],
            ['label' => 'Beasiswa', 'url' => '#', 'icon' => 'gift', 'color' => 'amber'],
        ];

        foreach ($quickLinks as $link) {
            QuickLink::create($link);
        }
    }
}
