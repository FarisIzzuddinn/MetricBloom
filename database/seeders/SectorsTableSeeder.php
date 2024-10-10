<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sectors')->insert([
            ['id' => 1, 'name' => 'Bahagian Keselamatan & Inteligen'],
            ['id' => 2, 'name' => 'Bahagian Pengurusan Banduan'],
            ['id' => 3, 'name' => 'Bahagian Banduan / Tahanan Radikal'],
            ['id' => 4, 'name' => 'Bahagaian Pembangunan Profesionalisme'],
            ['id' => 5, 'name' => 'Bahagian Sumber Manusia'],
            ['id' => 6, 'name' => 'Bahagian Kewangan'],
            ['id' => 7, 'name' => 'Bahagian Pembangunan Dan Perolehan'],
            ['id' => 8, 'name' => 'Bahagian Teknologi Maklumat'],
            ['id' => 9, 'name' => 'Bahagian Parol Dan Perkhidmatan Komuniti'],
            ['id' => 10, 'name' => 'Bahagian Agama & Kaunseling'],
            ['id' => 11, 'name' => 'Bahagian Hal Ehwal Pemindahan Antarabangsa'],
            ['id' => 12, 'name' => 'Bahagian Dasar Kepenjaraan'],
            ['id' => 13, 'name' => 'Unit Integriti'],
            ['id' => 14, 'name' => 'Unit Perundangan'],
            ['id' => 15, 'name' => 'Unit Teknikal Risikan Dan Siasatan'],
        ]);
    }
}
