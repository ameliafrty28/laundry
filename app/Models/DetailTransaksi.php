<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksi extends Model
{
    use SoftDeletes;

     protected $table = 'detail_transaksi';
    protected $primaryKey = 'detail_id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'transaksi_id',
        'layanan_id',
        'detail_qty',
        'detail_berat',
        'detail_subtotal'
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id', 'layanan_id');
    }
}