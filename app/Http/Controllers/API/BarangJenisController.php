<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BarangJenis;
use Illuminate\Http\Request;

class BarangJenisController extends Controller
{
    public function getBarangJenis()
    {
        $barangjenis = BarangJenis::all();

        if ($barangjenis) {
            $response = [
                'is_valid' => true,
                'data' => $barangjenis
            ];
        } else {
            $response = [
                'is_valid' => false,
                'data' => 'Barang Jenis Not Found'
            ];
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $insert = BarangJenis::create([
            'nama_jenis' => $request->nama_jenis
        ]);

        if ($insert) {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Jenis Berhasil Ditambah'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Jenis Gagal Ditambah'
            ];
        }
        return response()->json($response);
    }

    public function show($id)
    {
        $barangjenis = BarangJenis::findOrFail($id);

        return response()->json($barangjenis);
    }

    public function update(Request $request, $id)
    {
        $barangjenis = BarangJenis::findOrFail($id);

        $update = $barangjenis->update([
            'nama_jenis' => $request->nama_jenis
        ]);

        if ($update) {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Jenis Berhasil Diupdate'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Jenis Gagal Diupdate'
            ];
        }

        return response()->json($response);
    }

    public function destroy($id)
    {
        $barangjenis = BarangJenis::findOrFail($id);

        $delete = $barangjenis->delete($id);

        if ($delete) {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Jenis Berhasil Dihapus'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Barang Jenis Gagal Dihapus'
            ];
        }

        return response()->json($response);
    }
}
