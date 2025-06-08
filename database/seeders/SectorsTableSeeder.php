<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $now = Carbon::now();
        
        DB::table('sectors')->insert([
            ['id' => 1, 'name' => 'Sektor Keselamatan Dan Koreksional', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
            ['id' => 2, 'name' => 'Sektor Pengurusan', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
            ['id' => 3, 'name' => 'Sektor Pemasyarakatan', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
            ['id' => 4, 'name' => 'Bahagian & Unit', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
        ]);
    }
}
