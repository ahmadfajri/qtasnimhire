<?php

namespace App\Repositories\BarangJenis;

interface BarangJenisRepositoryInterface
{
    public function getBarangJenis();
    public function store(array $data);
    public function getForDataTable();
    public function getById($id);
    public function update(array $data, $id);
    public function delete($id);
}
