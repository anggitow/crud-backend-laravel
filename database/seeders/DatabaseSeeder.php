<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pelanggan')->insert([
            ['nama' => 'Anggito Wicaksono', 'domisili' => 'Jak-Ut', 'jenis_kelamin' => 'Pria'],
            ['nama' => 'Sintha', 'domisili' => 'Jak-Tim', 'jenis_kelamin' => 'Wanita'],
            ['nama' => 'Budi', 'domisili' => 'Jak-Bar', 'jenis_kelamin' => 'Pria']
        ]);

        DB::table('barang')->insert([
            ['nama' => 'Pensil', 'kategori' => 'ATK', 'harga' => 10000],
            ['nama' => 'Payung', 'kategori' => 'RT', 'harga' => 70000],
            ['nama' => 'Kipas', 'kategori' => 'Elektronik', 'harga' => 200000]
        ]);

        DB::table('penjualan')->insert([
            ['tanggal' => '2022-10-01', 'id_pelanggan' => 1, 'grand_total' => 90000],
            ['tanggal' => '2022-10-21', 'id_pelanggan' => 2, 'grand_total' => 400000]
        ]);

        DB::table('item_penjualan')->insert([
            ['id_penjualan' => 1, 'id_barang' => 1, 'qty' => 2],
            ['id_penjualan' => 1, 'id_barang' => 2, 'qty' => 1],
            ['id_penjualan' => 2, 'id_barang' => 3, 'qty' => 2]
        ]);
    }
}
