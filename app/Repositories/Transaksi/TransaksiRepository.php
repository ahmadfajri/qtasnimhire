<?php

namespace App\Repositories\Transaksi;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TransaksiRepository implements TransaksiRepositoryInterface
{
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $barang = Barang::find($data['barang']);

            if (!$barang) {
                throw new \Exception('Barang tidak ditemukan.');
            }

            $newStok = $barang->stok - $data['jumlah_terjual'];
            $barang->update(['stok' => $newStok]);

            $transaksi = Transaksi::create([
                'tgl_transaksi' => $data['tgl_transaksi'],
                'barang_id' => $data['barang'],
                'current_stok' => $data['stok'],
                'jumlah_terjual' => $data['jumlah_terjual'],
            ]);

            DB::commit();

            return $transaksi;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getForDataTable(array $data)
    {

        $query = Transaksi::join('barang', 'transaksi.barang_id', '=', 'barang.id')
            ->join('barang_jenis', 'barang.barang_jenis_id', '=', 'barang_jenis.id')->select('transaksi.*', 'barang.nama_barang', 'barang_jenis.nama_jenis');

        if (!empty($data['search_nama_barang'])) {
            $searchNamaBarang = $data['search_nama_barang'];
            $query->where('barang.nama_barang', 'like', '%' . $searchNamaBarang . '%');
        }

        if (!empty($data['urut_nama_barang'])) {
            $urutNamaBarang = $data['urut_nama_barang'];
            $query->orderBy('barang.nama_barang', $urutNamaBarang);
        }

        if (!empty($data['urut_tgl_transaksi'])) {
            $urutTglTransaksi = $data['urut_tgl_transaksi'];
            $query->orderBy('transaksi.tgl_transaksi', $urutTglTransaksi);
        }


        $transaksi = $query->get();

        return DataTables::of($transaksi)
            ->addIndexColumn()
            ->make(true);
    }

    public function getById($id)
    {
        $transaksi = Transaksi::join('barang', 'transaksi.barang_id', '=', 'barang.id')
            ->select('transaksi.*', 'barang.nama_barang')
            ->where('transaksi.id', $id)
            ->firstOrFail();

        return $transaksi;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $query = $this->getById($id);

            $barang = Barang::find($query->barang_id);

            $newStok = $barang->stok + $query->jumlah_terjual;
            $barang->update(['stok' => $newStok]);

            $transaksi = $query->delete();

            DB::commit();

            return $transaksi;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
