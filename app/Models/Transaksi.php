<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['tgl_transaksi', 'barang_id', 'current_stok', 'jumlah_terjual', 'created_at', 'updated_at'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
