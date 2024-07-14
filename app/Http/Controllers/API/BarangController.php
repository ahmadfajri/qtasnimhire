<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function getBarang()
    {
        $barang = Barang::with('barangJenis')->get();

        if ($barang) {
            $response = [
                'is_valid' => true,
                'data' => $barang
            ];
        } else {
            $response = [
                'is_valid' => false,
                'data' => 'Barang Not Found'
            ];
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $insert = Barang::create([
            'nama_barang' => $request->nama_barang,
            'barang_jenis_id' => $request->barang_jenis_id,
            'stok' => $request->stok
        ]);

        if ($insert) {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Berhasil Ditambah'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Gagal Ditambah'
            ];
        }
        return response()->json($response);
    }

    public function show($id)
    {
        $barang = Barang::with('barangJenis')->findOrFail($id);

        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $update = $barang->update([
            'nama_barang' => $request->nama_barang,
            'barang_jenis_id' => $request->barang_jenis_id,
        ]);

        if ($update) {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Berhasil Diupdate'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Gagal Diupdate'
            ];
        }

        return response()->json($response);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $delete = $barang->delete($id);

        if ($delete) {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Berhasil Dihapus'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Gagal Dihapus'
            ];
        }

        return response()->json($response);
    }
}
