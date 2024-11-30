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
            ['id' => 1, 'name' => 'Sektor Keselamatan Dan Koreksional'],
            ['id' => 2, 'name' => 'Sektor Pengurusan'],
            ['id' => 3, 'name' => 'Sektor Pemasyarakatan'],
            ['id' => 4, 'name' => 'Bahagian & Unit'],
        ]);
    }
}
