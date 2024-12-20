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
            ['id' => 1, 'nama_bahagian' => 'Bahagian Keselamatan & Inteligen', 'sector_id' => 1],
            ['id' => 2, 'nama_bahagian' => 'Bahagian Pengurusan Banduan', 'sector_id' => 1 ],
            ['id' => 3, 'nama_bahagian' => 'Bahagian Banduan Tahanan/Radikal', 'sector_id' => 1],
            ['id' => 4, 'nama_bahagian' => 'Bahagian Pembangunan Profesionalisme', 'sector_id' => 2],
            ['id' => 5, 'nama_bahagian' => 'Bahagian Sumber Manusia', 'sector_id' => 2],
            ['id' => 6, 'nama_bahagian' => 'Bahagian Kewangan', 'sector_id' => 2],
            ['id' => 7, 'nama_bahagian' => 'Bahagian Pembangunan & Perolehan', 'sector_id' => 2],
            ['id' => 8, 'nama_bahagian' => 'Bahagian Teknologi Maklumat', 'sector_id' => 2],
            ['id' => 9, 'nama_bahagian' => 'Bahagian Parol & Perkhidmatan Komuniti', 'sector_id' => 3],
            ['id' => 10, 'nama_bahagian' => 'Bahagian Agama & Kaunseling', 'sector_id' => 3],
            ['id' => 11, 'nama_bahagian' => 'Bahagian Hal Ehwal Pemindahan Antarabangsa', 'sector_id' => 3],
            ['id' => 12, 'nama_bahagian' => 'Bahagian Dasar Kepenjaraan', 'sector_id' => 4],
            ['id' => 13, 'nama_bahagian' => 'Bahagian Unit Integriti', 'sector_id' => 4],
            ['id' => 14, 'nama_bahagian' => 'Bahagian Perundangan', 'sector_id' => 4],
            ['id' => 15, 'nama_bahagian' => 'Bahagian Teknikal Risikan Dan Siasatan', 'sector_id' => 4],
        ]);
    }
}
