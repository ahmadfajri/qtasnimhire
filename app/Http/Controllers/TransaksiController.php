<?php

namespace App\Http\Controllers;

use App\Services\TransaksiServices;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    protected $transaksiServices;

    public function __construct(TransaksiServices $transaksiServices)
    {
        $this->transaksiServices = $transaksiServices;
    }

    public function index()
    {
        $barang = $this->transaksiServices->getBarang();
        return view('pages.transaksi.index', compact('barang'));
    }

    public function get(Request $request)
    {
        return $this->transaksiServices->getForDataTable($request->all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang' => 'required|string|max:255',
            'jumlah_terjual' => 'required|numeric',
            'tgl_transaksi' => 'required',
        ]);

        $transaksi = $this->transaksiServices->store($request->all());

        return response()->json(['success' => 'Transaksi berhasil ditambahkan', 'transaksi' => $transaksi]);
    }

    public function destroy($id)
    {
        $this->transaksiServices->delete($id);

        return response()->json(['success' => 'Transaksi berhasil dihapus']);
    }
}
