<?php

namespace Database\Seeders;

use App\Models\Surat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Surat::truncate();

        $letters = [
            [
                'name' => "Surat Keterangan Domisili",
                'description' => "Surat ini digunakan untuk menyatakan bahwa seseorang tinggal di alamat tertentu dalam wilayah administrasi desa/kelurahan.",
            ],
            [ 
                'name' => "Surat Keterangan Tidak Mampu (SKTM)",
                'description' => "Surat ini digunakan untuk menyatakan bahwa seseorang atau keluarga tergolong tidak mampu secara ekonomi, biasanya untuk keperluan bantuan sosial atau pendidikan.",
            ],
            [
                'name' => "Surat Izin Usaha Mikro Kecil",
                'description' => "Surat ini digunakan untuk memberikan izin usaha bagi pelaku usaha mikro kecil di wilayah administrasi tertentu.",
            ],
            [
                'name' => "Surat Pengantar Pindah Domisili",
                'description' => "Surat ini digunakan untuk mengajukan permohonan pindah domisili dari satu wilayah ke wilayah lainnya, disertai data pendukung.",
            ],  
        ];

        foreach ($letters as $letter) {
            Surat::create($letter);
        }
    }
}
