<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('barang')->select('id as key', 'nama', 'kategori', 'harga')->get();
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
        $data = [
            'nama' => $request->input('nama'),
            'kategori' => $request->input('kategori'),
            'harga' => $request->input('harga'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insert = DB::table('barang')->insert($data);
        if ($insert) {
            return response()->json([
                'success' => true,
                'message' => 'Data Barang Berhasil Ditambahkan'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Barang Gagal Ditambahkan'
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
        $data = DB::table('barang')->where('id', $id)->first();
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Data barang ditemukan',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message'=>'Data barang tidak ditemukan',
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
        $data = [
            'nama' => $request->input('nama'),
            'kategori' => $request->input('kategori'),
            'harga' => $request->input('harga'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $update = DB::table('barang')->where('id', $id)->update($data);
        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Data Barang Berhasil Diubah'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Barang Gagal Diubah'
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
        $delete = DB::table('barang')->where('id', $id)->delete();
        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data Barang Berhasil Dihapus'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Barang Gagal Dihapus'
            ]);
        }
    }
}
