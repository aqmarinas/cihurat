<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory;

    protected $table = 'surat_pengantar';

    protected $fillable = [
        'nama',
        'nik',
        'no_whatsapp',
        'ttl',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'keperluan',
        'rt',
        'rw',
        'ketua_rw',
        'ketua_rt',
        'ktp',
        'kk'
    ];
}
