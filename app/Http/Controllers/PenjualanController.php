<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('penjualan')
            ->join('pelanggan', 'pelanggan.id', 'penjualan.id_pelanggan')
            ->select('penjualan.id as key', 'penjualan.tanggal', 'penjualan.id_pelanggan', 'pelanggan.nama', 'penjualan.grand_total')
            ->get();
        foreach ($data as $key => $value) {
            $value->item_penjualan = DB::table('item_penjualan')
                ->join('barang', 'barang.id', 'item_penjualan.id_barang')
                ->where('item_penjualan.id_penjualan', $value->key)
                ->select('item_penjualan.id as key', 'item_penjualan.id_barang', 'barang.nama', 'item_penjualan.qty', 'barang.harga')
                ->get();
        }
        return response()->json([
            'success' => true,
            'message' => 'Sukses',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $idPelanggan = $request->input('pelanggan');
        $listBarang = $request->input('listBarang');

        $grandTotal = 0;
        foreach ($listBarang as $key => $value) {
            $harga = DB::table('barang')->where('id', $value['barang'])->select('harga')->first();
            $grandTotal += $harga->harga * $value['qty'];
        }

        $dataPenjualan = [
            'tanggal' => $tanggal,
            'id_pelanggan' => $idPelanggan,
            'grand_total' => $grandTotal,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            DB::transaction(function () use ($dataPenjualan, $listBarang) {
                $idPenjualan = DB::table('penjualan')->insertGetId($dataPenjualan);
                foreach ($listBarang as $key => $value) {
                    DB::table('item_penjualan')->insert([
                        'id_penjualan' => $idPenjualan,
                        'id_barang' => $value['barang'],
                        'qty' => $value['qty'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            });
            return response()->json([
                'success' => true,
                'message' => 'Data Penjualan Berhasil Ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pelanggan Gagal Ditambahkan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = DB::table('penjualan')->where('id', $id)->select('tanggal', 'id_pelanggan as pelanggan')->first();

        if ($penjualan != null) {
            $penjualan->listBarang = DB::table('item_penjualan')
                ->where('id_penjualan', $id)
                ->select('id_barang as barang', 'qty')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Data penjualan ditemukan',
                'data' => $penjualan
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data penjualan tidak ditemukan',
                'data' => null
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tanggal = $request->input('tanggal');
        $idPelanggan = $request->input('pelanggan');
        $listBarang = $request->input('listBarang');

        $penjualan = DB::table('penjualan')->where('id', $id)->select('created_at')->first();

        $grandTotal = 0;
        foreach ($listBarang as $key => $value) {
            $harga = DB::table('barang')->where('id', $value['barang'])->select('harga')->first();
            $grandTotal += $harga->harga * $value['qty'];
        }

        $dataPenjualan = [
            'tanggal' => $tanggal,
            'id_pelanggan' => $idPelanggan,
            'grand_total' => $grandTotal,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            DB::transaction(function () use ($id, $dataPenjualan, $listBarang, $penjualan) {
                DB::table('penjualan')->where('id', $id)->update($dataPenjualan);
                DB::table('item_penjualan')->where('id_penjualan', $id)->delete();
                foreach ($listBarang as $key => $value) {
                    DB::table('item_penjualan')->insert([
                        'id_penjualan' => $id,
                        'id_barang' => $value['barang'],
                        'qty' => $value['qty'],
                        'created_at' => $penjualan->created_at,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            });
            return response()->json([
                'success' => true,
                'message' => 'Data Penjualan Berhasil Diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pelanggan Gagal Diubah'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                DB::table('penjualan')->where('id', $id)->delete();
                DB::table('item_penjualan')->where('id_penjualan', $id)->delete();
            });
            return response()->json([
                'success' => true,
                'message' => 'Data Penjualan Berhasil Dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Data Penjualan Gagal Dihapus'
            ]);
        }
    }
}
