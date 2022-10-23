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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
