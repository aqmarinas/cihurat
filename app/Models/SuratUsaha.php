<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratUsaha extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'surat_usaha';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
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

    public function surat()
    {
        return $this->morphOne(Surat::class, 'suratable');
    }
}
