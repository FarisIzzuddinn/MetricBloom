<?php

namespace Database\Seeders;

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
        $states = [
            ['name' => 'Johor'],
            ['name' => 'Kedah'],
            ['name' => 'Kelantan'],
            ['name' => 'Melaka'],
            ['name' => 'Negeri Sembilan'],
            ['name' => 'Pahang'],
            ['name' => 'Perak'],
            ['name' => 'Perlis'],
            ['name' => 'Pulau Pinang'],
            ['name' => 'Sabah'],
            ['name' => 'Sarawak'],
            ['name' => 'Selangor'],
            ['name' => 'Terengganu'],
            ['name' => 'Wilayah Persekutuan Kuala Lumpur'],
            ['name' => 'Wilayah Persekutuan Labuan'],
            ['name' => 'Wilayah Persekutuan Putrajaya'],
        ];

        // Insert data into the states table
        DB::table('states')->insert($states);
    }
}
