<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
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
        JenisSurat::truncate();

        $letters = [
            [
                'name' => "Surat Pengantar RT/RW",
                'description' => "Surat ini dikeluarkan oleh Ketua RT atau RW untuk mendukung keperluan administratif tertentu, seperti pengurusan dokumen kependudukan atau surat lainnya di tingkat desa atau kecamatan.",
            ],
            [
                'name' => "Surat Keterangan Domisili",
                'description' => "Surat ini digunakan untuk menyatakan bahwa seseorang tinggal di alamat tertentu dalam wilayah administrasi desa atau kelurahan.",
            ],

            [
                'name' => "Surat Keterangan Tidak Mampu",
                'description' => "Surat resmi yang menyatakan bahwa seseorang atau keluarganya tergolong tidak mampu secara ekonomi. Biasanya digunakan untuk keperluan bantuan sosial, pendidikan, atau subsidi pemerintah.",
            ],
            [
                'name' => "Surat Keterangan Kematian",
                'description' => "Surat yang menerangkan bahwa seseorang telah meninggal dunia. Digunakan untuk keperluan administrasi seperti pencatatan kematian, klaim asuransi, atau pengurusan hak waris.",
            ],
            [
                'name' => "Surat Keterangan Usaha",
                'description' => "Surat yang menyatakan keberadaan dan legalitas usaha seseorang. Biasanya digunakan untuk keperluan administratif seperti pengajuan kredit usaha atau perizinan.",
            ],
            [
                'name' => "Surat Keterangan Belum Menikah",
                'description' => "Surat yang menyatakan bahwa seseorang belum pernah menikah. Digunakan untuk keperluan administrasi seperti persyaratan menikah atau pengurusan dokumen tertentu.",
            ],
            // [
            //     'name' => "Surat Keterangan Ahli Waris",
            //     'description' => "Surat yang menyatakan bahwa pihak-pihak tertentu adalah ahli waris sah dari seseorang yang telah meninggal dunia. Biasanya digunakan untuk pembagian aset atau hak warisan.",
            // ],
            // [
            //     'name' => "Surat Keterangan Ahli Waris Bank",
            //     'description' => "Surat khusus yang menyatakan ahli waris sah untuk mengklaim harta atau rekening bank milik seseorang yang telah meninggal dunia.",
            // ],
            // [
            //     'name' => "Surat Keterangan Beda Nama",
            //     'description' => "Surat yang menerangkan bahwa dua nama berbeda di dokumen resmi merujuk pada orang yang sama. Digunakan untuk menyelesaikan masalah administrasi akibat perbedaan nama.",
            // ],
            // [
            //     'name' => "Surat Pernyataan Kepemilikan Tanah",
            //     'description' => "Surat yang menyatakan kepemilikan tanah tertentu oleh seseorang. Biasanya digunakan untuk keperluan sertifikasi tanah, jual beli, atau penyelesaian sengketa tanah.",
            // ],
        ];


        foreach ($letters as $letter) {
            JenisSurat::create($letter);
        }
    }
}
