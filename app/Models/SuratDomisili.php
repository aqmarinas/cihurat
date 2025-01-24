<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDomisili extends Model
{
    use HasFactory;

    protected $table = 'surat_domisili';

    protected $fillable = [
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'status_kawin',
        'agama',
        'pekerjaan',
        'alamat',
        'keperluan',
        'no_whatsapp',
    ];

    public function surat()
    {
        return $this->morphOne(Surat::class, 'suratable');
    }
}
