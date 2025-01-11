<?php

namespace Database\Seeders;

use App\Models\RtRw;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RtRwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RtRw::truncate();
        
        $rtRwLists = [
            [
                'rt_rw' => "01",
                'nama_ketua' => "Ridwan",
                'nomor_whatsapp' => "081234567890",
            ],
            [
                'rt_rw' => "02",
                'nama_ketua' => "Ridwan",
                'nomor_whatsapp' => "081234567890",
            ],
        ];

        foreach ($rtRwLists as $rtRwList) {
            RtRw::create($rtRwList);
        }
    }
}
