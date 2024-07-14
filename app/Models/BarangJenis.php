<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangJenis extends Model
{
    use HasFactory;

    protected $table = 'barang_jenis';
    protected $fillable = ['nama_jenis', 'created_at', 'updated_at'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'barang_jenis_id');
    }
}
