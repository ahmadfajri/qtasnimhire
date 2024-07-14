<?php

namespace App\Repositories\TransaksiPerJenis;

use App\Models\BarangJenis;
use Yajra\DataTables\DataTables;

class TransaksiPerJenisRepository implements TransaksiPerJenisRepositoryInterface
{

    public function getForDataTable(array $data)
    {
        if (!empty($data['dari']) && !empty($data['sampai'])) {
            $dari = $data['dari'];
            $sampai = $data['sampai'];
        } else {
            $dari = date('Y-m-d');
            $sampai = date('Y-m-d');
        }
        $query = BarangJenis::select('nama_jenis')
            ->join('barang', 'barang.barang_jenis_id', '=', 'barang_jenis.id')
            ->join('transaksi', 'transaksi.barang_id', '=', 'barang.id')
            ->whereBetween('transaksi.tgl_transaksi', [$dari, $sampai])
            ->selectRaw('barang_jenis.nama_jenis, SUM(transaksi.jumlah_terjual) as total_terjual')
            ->groupBy('barang_jenis.nama_jenis');

        $transaksi = $query->get();

        return DataTables::of($transaksi)
            ->addIndexColumn()
            ->make(true);
    }
}
