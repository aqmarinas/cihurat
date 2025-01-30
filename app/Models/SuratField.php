<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratField extends Model
{
    use HasFactory;

    protected $table = 'fields_letter';

    protected $fillable = [
        'jenis_surat',
        'field_name',
        'label'
    ];
}
