<?php

namespace App\Services;

use App\Repositories\Barang\BarangRepository;
use App\Repositories\Transaksi\TransaksiRepository;

class TransaksiServices
{
    protected $barangRepository;
    protected $transaksiRepository;

    public function __construct(BarangRepository $barangRepository, TransaksiRepository $transaksiRepository)
    {
        $this->barangRepository = $barangRepository;
        $this->transaksiRepository = $transaksiRepository;
    }

    public function getBarang()
    {
        return $this->barangRepository->getAll();
    }

    public function store(array $data)
    {
        return $this->transaksiRepository->store($data);
    }

    public function getForDataTable(array $data)
    {
        return $this->transaksiRepository->getForDataTable($data);
    }

    public function getById($id)
    {
        return $this->transaksiRepository->getById($id);
    }

    public function delete($id)
    {
        return $this->transaksiRepository->delete($id);
    }
}
