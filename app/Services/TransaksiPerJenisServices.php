<?php

namespace App\Services;

use App\Repositories\BarangJenis\BarangJenisRepository;
use App\Repositories\TransaksiPerJenis\TransaksiPerJenisRepository;

class TransaksiPerJenisServices
{
    protected $barangJenisRepository;
    protected $transaksiPerJenisRepository;

    public function __construct(BarangJenisRepository $barangJenisRepository, TransaksiPerJenisRepository $transaksiPerJenisRepository)
    {
        $this->barangJenisRepository = $barangJenisRepository;
        $this->transaksiPerJenisRepository = $transaksiPerJenisRepository;
    }

    public function getBarangJenis()
    {
        return $this->barangJenisRepository->getBarangJenis();
    }

    public function getForDataTable(array $data)
    {
        return $this->transaksiPerJenisRepository->getForDataTable($data);
    }
}
