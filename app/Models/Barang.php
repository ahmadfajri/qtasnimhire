<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['nama_barang', 'barang_jenis_id', 'stok', 'barang_stok_id', 'created_at', 'updated_at'];

    public function barangJenis()
    {
        return $this->belongsTo(BarangJenis::class, 'barang_jenis_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'barang_id');
    }
}
