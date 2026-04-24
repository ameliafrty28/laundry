<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';

    protected $primaryKey = 'layanan_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'layanan_nama',
        'layanan_jenis',
        'layanan_harga'
    ];
}