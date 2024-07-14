<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangJenis;
use App\Models\Transaksi;

class HomeController extends Controller
{
    public function index()
    {
        $barangjenis = BarangJenis::count();
        $barang = Barang::count();
        $transaksi = Transaksi::count();
        return view('home', compact('barangjenis', 'barang', 'transaksi'));
    }
}
