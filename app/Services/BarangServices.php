<?php

namespace App\Services;

use App\Repositories\BarangJenis\BarangJenisRepository;
use App\Repositories\Barang\BarangRepository;

class BarangServices
{
    protected $barangJenisRepository;
    protected $barangRepository;

    public function __construct(BarangJenisRepository $barangJenisRepository, BarangRepository $barangRepository)
    {
        $this->barangJenisRepository = $barangJenisRepository;
        $this->barangRepository = $barangRepository;
    }

    public function getBarangJenis()
    {
        return $this->barangJenisRepository->getBarangJenis();
    }

    public function store(array $data)
    {
        return $this->barangRepository->store($data);
    }

    public function getForDataTable()
    {
        return $this->barangRepository->getForDataTable();
    }

    public function getById($id)
    {
        return $this->barangRepository->getById($id);
    }

    public function update(array $data, $id)
    {
        return $this->barangRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->barangRepository->delete($id);
    }
}
