<?php

namespace App\Http\Controllers;

use App\Services\BarangJenisServices;
use Illuminate\Http\Request;

class BarangJenisController extends Controller
{
    protected $barangJenisServices;

    public function __construct(BarangJenisServices $barangJenisServices)
    {
        $this->barangJenisServices = $barangJenisServices;
    }

    public function index()
    {
        $barangjenis = $this->barangJenisServices->getBarangJenis();
        return view('pages.barangjenis.index', compact('barangjenis'));
    }

    public function get()
    {
        return $this->barangJenisServices->getForDataTable();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        $barangjenis = $this->barangJenisServices->store($request->all());

        return response()->json(['success' => 'Barang Jenis berhasil ditambahkan', 'barangjenis' => $barangjenis]);
    }

    public function show($id)
    {
        $barangjenis = $this->barangJenisServices->getById($id);

        return response()->json($barangjenis);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        $this->barangJenisServices->update($request->all(), $id);

        return response()->json(['success' => 'Barang Jenis berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $this->barangJenisServices->delete($id);

        return response()->json(['success' => 'Barang Jenis berhasil dihapus']);
    }
}
