<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('pelanggan')->select('id as key', 'nama', 'domisili', 'jenis_kelamin')->get();
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
            'domisili' => $request->input('domisili'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insert = DB::table('pelanggan')->insert($data);
        if ($insert) {
            return response()->json([
                'success' => true,
                'message' => 'Data Pelanggan Berhasil Ditambahkan'
            ]);
        } else {
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
        $data = DB::table('pelanggan')->where('id', $id)->first();
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Data pelanggan ditemukan',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message'=>'Data pelanggan tidak ditemukan',
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
            'domisili' => $request->input('domisili'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $update = DB::table('pelanggan')->where('id', $id)->update($data);
        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Data Pelanggan Berhasil Diubah'
            ]);
        } else {
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
        $delete = DB::table('pelanggan')->where('id', $id)->delete();
        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data Pelanggan Berhasil Dihapus'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Pelanggan Gagal Dihapus'
            ]);
        }
        
    }
}
