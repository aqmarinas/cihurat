<?php

namespace Database\Seeders;

use App\Models\Rw;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rw::truncate();

        $rwList = [
            [
                'nama' => 'Amas Darmas',
                'rw' => '01',
                'no_whatsapp' => '0812345678931',
            ],
            [
                'nama' => 'Tian Kartina',
                'rw' => '02',
                'no_whatsapp' => '0812345678932',
            ],
            [
                'nama' => 'Lili Mukhlis',
                'rw' => '03',
                'no_whatsapp' => '0812345678933',
            ],
            [
                'nama' => 'Sunardi',
                'rw' => '04',
                'no_whatsapp' => '0812345678934',
            ]
        ];

        foreach ($rwList as $rw) {
            Rw::create($rw);
        }
    }
}
