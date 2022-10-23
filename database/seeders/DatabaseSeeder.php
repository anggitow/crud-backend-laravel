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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('pelanggan')->insert([
            ['nama' => 'Andi', 'domisili' => 'Jak-Ut', 'jenis_kelamin' => 'Pria'],
            ['nama' => 'Budi', 'domisili' => 'Jak-Bar', 'jenis_kelamin' => 'Pria'],
            ['nama' => 'Sintha', 'domisili' => 'Jak-Tim', 'jenis_kelamin' => 'Wanita']
        ]);
    }
}
