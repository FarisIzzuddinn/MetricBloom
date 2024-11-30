<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class terasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teras')->insert([
            ['id' => 1, 'teras' => 'Pemerkasaan Keselamatan'],
            ['id' => 2, 'teras' => 'Pengukuhan Pengurusan Pesalah Bersepadu'],
            ['id' => 3, 'teras' => 'Pembentukan Komuniti Inklusif'],
            ['id' => 4, 'teras' => 'Pemantapan Institusi Dan Sistem Penyampaian'],
        ]);
    }
}
