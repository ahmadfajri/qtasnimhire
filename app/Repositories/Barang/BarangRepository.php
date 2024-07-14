<?php

namespace App\Repositories\Barang;

use App\Models\Barang;
use Yajra\DataTables\DataTables;

class BarangRepository implements BarangRepositoryInterface
{
    public function getAll()
    {
        return Barang::all();
    }

    public function store(array $data)
    {
        return Barang::create([
            'nama_barang' => $data['nama_barang'],
            'barang_jenis_id' => $data['jenis'],
            'stok' => $data['stok'],
        ]);
    }

    public function getForDataTable()
    {
        $barang = Barang::join('barang_jenis', 'barang.barang_jenis_id', '=', 'barang_jenis.id')->select('barang.id', 'barang.nama_barang', 'barang.stok', 'barang_jenis.nama_jenis')->get();

        return DataTables::of($barang)
            ->addIndexColumn()
            ->make(true);
    }

    public function getById($id)
    {
        $barang = Barang::join('barang_jenis', 'barang.barang_jenis_id', '=', 'barang_jenis.id')
            ->select('barang.*', 'barang_jenis.nama_jenis')
            ->where('barang.id', $id)
            ->firstOrFail();
        return $barang;
    }

    public function update(array $data, $id)
    {
        $barang = $this->getById($id);

        $barang->update([
            'nama_barang' => $data['nama_barang'],
            'barang_jenis_id' => $data['jenis'],
        ]);

        return $barang;
    }

    public function delete($id)
    {
        $barang = $this->getById($id);

        $barang->delete();

        return $barang;
    }
}
