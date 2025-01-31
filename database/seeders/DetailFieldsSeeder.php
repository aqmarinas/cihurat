<?php

namespace Database\Seeders;

use App\Models\SuratField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuratField::truncate();

        $suratFields = [
            "Surat Pengantar" => [
                ['field_name' => 'nama', 'label' => 'Nama'],
                ['field_name' => 'nik', 'label' => 'NIK'],
                ['field_name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp'],
                ['field_name' => 'ttl', 'label' => 'Tempat, Tanggal Lahir'],
                ['field_name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin'],
                ['field_name' => 'agama', 'label' => 'Agama'],
                ['field_name' => 'pekerjaan', 'label' => 'Pekerjaan'],
                ['field_name' => 'keperluan', 'label' => 'Keperluan'],
            ],
            "Surat Domisili" => [
                ['field_name' => 'nama', 'label' => 'Nama'],
                ['field_name' => 'nik', 'label' => 'NIK'],
                ['field_name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp'],
                ['field_name' => 'ttl', 'label' => 'Tempat, Tanggal Lahir'],
                ['field_name' => 'status_kawin', 'label' => 'Status Perkawinan'],
                ['field_name' => 'agama', 'label' => 'Agama'],
                ['field_name' => 'pekerjaan', 'label' => 'Pekerjaan'],
                ['field_name' => 'alamat', 'label' => 'Alamat'],
                ['field_name' => 'keperluan', 'label' => 'Keperluan'],
            ],
            "Surat Keterangan Tidak Mampu" => [
                ['field_name' => 'nama_ortu', 'label' => 'Nama Orang Tua'],
                ['field_name' => 'nik_ortu', 'label' => 'NIK Orang Tua'],
                ['field_name' => 'ttl_ortu', 'label' => 'Tempat, Tanggal Lahir Orang Tua'],
                ['field_name' => 'jenis_kelamin_ortu', 'label' => 'Jenis Kelamin Orang Tua'],
                ['field_name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp'],
                ['field_name' => 'status_kawin', 'label' => 'Status Perkawinan'],
                ['field_name' => 'alamat', 'label' => 'Alamat'],
                ['field_name' => 'penghasilan', 'label' => 'Penghasilan Orang Tua'],
                ['field_name' => 'nama', 'label' => 'Nama Pemohon'],
                ['field_name' => 'nik', 'label' => 'NIK Pemohon'],
                ['field_name' => 'ttl', 'label' => 'Tempat, Tanggal Lahir Pemohon'],
                ['field_name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin Pemohon'],
                ['field_name' => 'sekolah', 'label' => 'Nama Sekolah'],
                ['field_name' => 'jurusan', 'label' => 'Jurusan'],
                ['field_name' => 'keperluan', 'label' => 'Keperluan Surat'],
            ],
            "Surat Keterangan Kematian" => [
                ['field_name' => 'nama', 'label' => 'Nama'],
                ['field_name' => 'nik', 'label' => 'NIK'],
                ['field_name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp'],
                ['field_name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin'],
                ['field_name' => 'alamat', 'label' => 'Alamat'],
                ['field_name' => 'hari_meninggal', 'label' => 'Hari Meninggal'],
                ['field_name' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal'],
                ['field_name' => 'tempat_meninggal', 'label' => 'Tempat Meninggal'],
                ['field_name' => 'sebab_meninggal', 'label' => 'Penyebab Meninggal'],
            ],
            "Surat Keterangan Usaha" => [
                ['field_name' => 'nama', 'label' => 'Nama'],
                ['field_name' => 'nik', 'label' => 'NIK'],
                ['field_name' => 'ttl', 'label' => 'Tempat, Tanggal Lahir'],
                ['field_name' => 'kewarganegaraan', 'label' => 'Kewarganegaraan'],
                ['field_name' => 'agama', 'label' => 'Agama'],
                ['field_name' => 'status_kawin', 'label' => 'Status Perkawinan'],
                ['field_name' => 'pekerjaan', 'label' => 'Pekerjaan'],
                ['field_name' => 'alamat', 'label' => 'Alamat'],
                ['field_name' => 'jenis_usaha', 'label' => 'Jenis Usaha'],
                ['field_name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp'],
            ],
            "Surat Keterangan Belum Menikah" => [
                ['field_name' => 'nama', 'label' => 'Nama'],
                ['field_name' => 'bin', 'label' => 'Bin/Binti'],
                ['field_name' => 'nik', 'label' => 'NIK'],
                ['field_name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp'],
                ['field_name' => 'ttl', 'label' => 'Tempat, Tanggal Lahir'],
                ['field_name' => 'agama', 'label' => 'Agama'],
                ['field_name' => 'kewarganegaraan', 'label' => 'Kewarganegaraan'],
                ['field_name' => 'status_kawin', 'label' => 'Status Perkawinan'],
                ['field_name' => 'pekerjaan', 'label' => 'Pekerjaan'],
                ['field_name' => 'alamat', 'label' => 'Alamat'],

            ],
        ];

        $allFields = [];
        $timestamp = now();

        foreach ($suratFields as $jenisSurat => $fields) {
            foreach ($fields as $field) {
                $allFields[] = [
                    'jenis_surat' => $jenisSurat,
                    'field_name' => $field['field_name'],
                    'label' => $field['label'],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        SuratField::insert($allFields); // insert tidak memasukan timestamp
    }
}
