<?php

namespace App\Repositories\Transaksi;

interface TransaksiRepositoryInterface
{
    public function store(array $data);
    public function getForDataTable(array $data);
    public function getById($id);
    public function delete($id);
}
