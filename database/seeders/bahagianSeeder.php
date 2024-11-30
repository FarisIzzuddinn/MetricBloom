<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bahagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bahagian')->insert([
            ['id' => 1, 'nama_bahagian' => 'Bahagian Keselamatan & Inteligen'],
            ['id' => 2, 'nama_bahagian' => 'Bahagian Pengurusan Banduan'],
            ['id' => 3, 'nama_bahagian' => 'Bahagian Banduan Tahanan/Radikal'],
            ['id' => 4, 'nama_bahagian' => 'Bahagian Pembangunan Profesionalisme'],
            ['id' => 5, 'nama_bahagian' => 'Bahagian Sumber Manusia'],
            ['id' => 6, 'nama_bahagian' => 'Bahagian Kewangan'],
            ['id' => 7, 'nama_bahagian' => 'Bahagian Pembangunan & Perolehan'],
            ['id' => 8, 'nama_bahagian' => 'Bahagian Teknologi Maklumat'],
            ['id' => 9, 'nama_bahagian' => 'Bahagian Parol & Perkhidmatan Komuniti'],
            ['id' => 10, 'nama_bahagian' => 'Bahagian Agama & Kaunseling'],
            ['id' => 11, 'nama_bahagian' => 'Bahagian Hal Ehwal Pemindahan Antarabangsa'],
            ['id' => 12, 'nama_bahagian' => 'Bahagian Dasar Kepenjaraan'],
            ['id' => 13, 'nama_bahagian' => 'Bahagian Unit Integriti'],
            ['id' => 14, 'nama_bahagian' => 'Bahagian Perundangan'],
            ['id' => 15, 'nama_bahagian' => 'Bahagian Teknikal Risikan Dan Siasatan'],
        ]);
    }
}
