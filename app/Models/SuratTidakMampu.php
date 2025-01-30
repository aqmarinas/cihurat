<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTidakMampu extends Model
{
    use HasFactory;

    protected $table = 'surat_tidak_mampu';

    protected $fillable = [
        'nama_ortu',
        'nik_ortu',
        'ttl_ortu',
        'jenis_kelamin_ortu',
        'no_whatsapp',
        'status_kawin',
        'alamat',
        'penghasilan',
        'nama',
        'nik',
        'ttl',
        'jenis_kelamin',
        'sekolah',
        'jurusan',
        'keperluan',
        'ktp',
        'kk',
        'surat_penghasilan',
        'foto_rumah'
    ];
}
