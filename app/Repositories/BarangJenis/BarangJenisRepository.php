<?php

namespace App\Repositories\BarangJenis;

use App\Models\BarangJenis;
use Yajra\DataTables\DataTables;

class BarangJenisRepository implements BarangJenisRepositoryInterface
{
    public function getBarangJenis()
    {
        $barangjenis = BarangJenis::all();

        return $barangjenis;
    }

    public function store(array $data)
    {
        return BarangJenis::create([
            'nama_jenis' => $data['nama_jenis']
        ]);
    }

    public function getForDataTable()
    {
        $barangjenis = BarangJenis::all();
        return DataTables::of($barangjenis)
            ->addIndexColumn()
            ->make(true);
    }

    public function getById($id)
    {
        $barangjenis = BarangJenis::findOrFail($id);
        return $barangjenis;
    }

    public function update(array $data, $id)
    {
        $barangjenis = $this->getById($id);

        $barangjenis->update([
            'nama_jenis' => $data['nama_jenis']
        ]);

        return $barangjenis;
    }

    public function delete($id)
    {
        $barangsatuan = $this->getById($id);

        $barangsatuan->delete();

        return $barangsatuan;
    }
}
