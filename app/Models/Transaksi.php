<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;

    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'transaksi_tanggal',
        'transaksi_total',
        'transaksi_dibayar',
        'transaksi_sisa',
        'transaksi_status_pembayaran',
        'transaksi_metode_pembayaran',
        'transaksi_status_pesanan'
    ];

protected static function boot()
{
    parent::boot();

    static::deleting(function ($transaksi) {

        // ambil SEMUA detail (termasuk yang sudah dihapus)
        $transaksi->detail()->withTrashed()->get()->each(function ($detail) {
            $detail->delete();
        });

    });

    static::restoring(function ($transaksi) {

        $transaksi->detail()->withTrashed()->restore();

    });
}

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'transaksi_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
}