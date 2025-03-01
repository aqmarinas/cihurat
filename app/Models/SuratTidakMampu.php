<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTidakMampu extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'surat_tidak_mampu';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
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
    ];

    public function surat()
    {
        return $this->morphOne(Surat::class, 'suratable');
    }
}
