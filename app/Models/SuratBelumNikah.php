<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratBelumNikah extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'surat_belum_nikah';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
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

    public function surat()
    {
        return $this->morphOne(Surat::class, 'suratable');
    }
}
