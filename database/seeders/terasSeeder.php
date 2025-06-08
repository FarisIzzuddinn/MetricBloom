<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $now = Carbon::now();
        
        DB::table('teras')->insert([
            ['id' => 1, 'name' => 'Pemerkasaan Keselamatan', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
            ['id' => 2, 'name' => 'Pengukuhan Pengurusan Pesalah Bersepadu', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
            ['id' => 3, 'name' => 'Pembentukan Komuniti Inklusif', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
            ['id' => 4, 'name' => 'Pemantapan Institusi Dan Sistem Penyampaian', 'created_at' => $now, 'created_by' => '1', 'updated_at' => $now, 'updated_by' => '1'],
        ]);
    }
}
