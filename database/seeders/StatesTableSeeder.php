<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $states = [
            ['name' => 'Johor', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kedah', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kelantan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Melaka', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Negeri Sembilan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pahang', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Perak', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Perlis', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pulau Pinang', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Selangor & W.P Kuala Lumpur', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Terengganu', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sabah & W.P Labuan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sarawak', 'created_at' => $now, 'updated_at' => $now],
        ];


        DB::table('states')->insert($states);
    }
}
