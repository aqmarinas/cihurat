<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratBelumNikah extends Model
{
    use HasFactory;

    protected $table = 'surat_belum_nikah';

    protected $fillable = [
        'nama',
        'bin',
        'nik',
        'ttl',
        'agama',
        'kewarganegaraan',
        'status_kawin',
        'pekerjaan',
        'alamat',
        'no_whatsapp',
        'ktp',
        'kk',
    ];
}
