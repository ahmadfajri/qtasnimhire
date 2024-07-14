<?php

namespace App\Repositories\Barang;

interface BarangRepositoryInterface
{
    public function store(array $data);
    public function getAll();
    public function getForDataTable();
    public function getById($id);
    public function update(array $data, $id);
    public function delete($id);
}
