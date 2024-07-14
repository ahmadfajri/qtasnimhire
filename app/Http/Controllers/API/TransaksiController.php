<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BarangJenis;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function getTransaksi()
    {
        $transaksi = Transaksi::with('barang')->get();

        if ($transaksi) {
            $response = [
                'is_valid' => true,
                'data' => $transaksi
            ];
        } else {
            $response = [
                'is_valid' => false,
                'data' => 'Transaksi Not Found'
            ];
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $insert = Transaksi::create([
            'tgl_transaksi' => $request->tgl_transaksi,
            'barang_id' => $request->barang_id,
            'current_stok' => $request->current_stok,
            'jumlah_terjual' => $request->jumlah_terjual
        ]);

        if ($insert) {
            $response = [
                'is_valid' => true,
                'data' => 'Transaksi Berhasil Ditambah'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Transaksi Gagal Ditambah'
            ];
        }

        return response()->json($response);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('barang')->findOrFail($id);

        return response()->json($transaksi);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $delete = $transaksi->delete($id);

        if ($delete) {
            $response = [
                'is_valid' => true,
                'data' => 'Transaksi Berhasil Dihapus'
            ];
        } else {
            $response = [
                'is_valid' => true,
                'data' => 'Transaksi Gagal Dihapus'
            ];
        }

        return response()->json($response);
    }

    public function getTransaksiPerJenis(Request $request)
    {

        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $transaksi = BarangJenis::select('nama_jenis')
            ->join('barang', 'barang.barang_jenis_id', '=', 'barang_jenis.id')
            ->join('transaksi', 'transaksi.barang_id', '=', 'barang.id')
            ->whereBetween('transaksi.tgl_transaksi', [$dari, $sampai])
            ->selectRaw('barang_jenis.nama_jenis, SUM(transaksi.jumlah_terjual) as total_terjual')
            ->groupBy('barang_jenis.nama_jenis')
            ->get();

        if ($transaksi) {
            $response = [
                'is_valid' => true,
                'data' => $transaksi
            ];
        } else {
            $response = [
                'is_valid' => false,
                'data' => 'Transaksi Not Found'
            ];
        }

        return response()->json($response);
    }
}
