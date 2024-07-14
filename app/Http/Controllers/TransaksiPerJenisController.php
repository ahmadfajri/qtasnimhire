<?php

namespace App\Http\Controllers;

use App\Services\TransaksiPerJenisServices;
use Illuminate\Http\Request;

class TransaksiPerJenisController extends Controller
{
    protected $transaksiPerJenisServices;

    public function __construct(TransaksiPerJenisServices $transaksiPerJenisServices)
    {
        $this->transaksiPerJenisServices = $transaksiPerJenisServices;
    }

    public function index()
    {
        $barangjenis = $this->transaksiPerJenisServices->getBarangJenis();
        return view('pages.transaksimaxmin.index', compact('barangjenis'));
    }

    public function get(Request $request)
    {
        return $this->transaksiPerJenisServices->getForDataTable($request->all());
    }
}
