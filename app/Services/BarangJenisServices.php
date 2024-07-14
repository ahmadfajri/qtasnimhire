<?php

namespace App\Services;

use App\Repositories\BarangJenis\BarangJenisRepository;

class BarangJenisServices
{
    protected $barangJenisRepository;

    public function __construct(BarangJenisRepository $barangJenisRepository)
    {
        $this->barangJenisRepository = $barangJenisRepository;
    }

    public function store(array $data)
    {
        return $this->barangJenisRepository->store($data);
    }

    public function getBarangJenis()
    {
        return $this->barangJenisRepository->getBarangJenis();
    }

    public function getForDataTable()
    {
        return $this->barangJenisRepository->getForDataTable();
    }

    public function getById($id)
    {
        return $this->barangJenisRepository->getById($id);
    }

    public function update(array $data, $id)
    {
        return $this->barangJenisRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->barangJenisRepository->delete($id);
    }
}
