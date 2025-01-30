<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratUsaha extends Model
{
    use HasFactory;

    protected $table = 'surat_usaha';

    protected $fillable = [
        'nama',
        'nik',
        'ttl',
        'kewarganegaraan',
        'agama',
        'status_kawin',
        'pekerjaan',
        'alamat',
        'jenis_usaha',
        'no_whatsapp',
        'ktp',
        'kk',
    ];
}
