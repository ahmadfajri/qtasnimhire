<?php

namespace App\Http\Controllers;

use App\Services\BarangServices;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    protected $barangServices;

    public function __construct(BarangServices $barangServices)
    {
        $this->barangServices = $barangServices;
    }

    public function index()
    {
        $barangjenis = $this->barangServices->getBarangJenis();
        return view('pages.barang.index', compact('barangjenis'));
    }

    public function get()
    {
        return $this->barangServices->getForDataTable();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required',
            'stok' => 'required'
        ]);

        $barang = $this->barangServices->store($request->all());

        return response()->json(['success' => 'Barang berhasil ditambahkan', 'barang' => $barang]);
    }

    public function show($id)
    {
        $barang = $this->barangServices->getById($id);

        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required',
        ]);

        $this->barangServices->update($request->all(), $id);

        return response()->json(['success' => 'Barang berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $this->barangServices->delete($id);

        return response()->json(['success' => 'Barang berhasil dihapus']);
    }
}
