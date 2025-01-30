<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    use HasFactory;

    protected $table = "rw";

    protected $fillable = [
        'nama',
        'rw',
        'no_whatsapp',
    ];
}
