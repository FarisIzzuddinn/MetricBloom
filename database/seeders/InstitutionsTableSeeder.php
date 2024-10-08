<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // List of prison institutions in Malaysia with associated state IDs
        $institutions = [
            ['name' => 'Penjara Kajang', 'state_id' => 12],  // Selangor
            ['name' => 'Penjara Sungai Buloh', 'state_id' => 12],  // Selangor
            ['name' => 'Penjara Pudu', 'state_id' => 14],  // Wilayah Persekutuan Kuala Lumpur
            ['name' => 'Penjara Johor Bahru', 'state_id' => 1],  // Johor
            ['name' => 'Penjara Kluang', 'state_id' => 1],  // Johor
            ['name' => 'Penjara Alor Setar', 'state_id' => 2],  // Kedah
            ['name' => 'Penjara Pengkalan Chepa', 'state_id' => 3],  // Kelantan
            ['name' => 'Penjara Melaka', 'state_id' => 4],  // Melaka
            ['name' => 'Penjara Seremban', 'state_id' => 5],  // Negeri Sembilan
            ['name' => 'Penjara Bentong', 'state_id' => 6],  // Pahang
            ['name' => 'Penjara Taiping', 'state_id' => 7],  // Perak
            ['name' => 'Penjara Kangar', 'state_id' => 8],  // Perlis
            ['name' => 'Penjara Seberang Perai', 'state_id' => 9],  // Pulau Pinang
            ['name' => 'Penjara Kota Kinabalu', 'state_id' => 10],  // Sabah
            ['name' => 'Penjara Kuching', 'state_id' => 11],  // Sarawak
            ['name' => 'Penjara Marang', 'state_id' => 13],  // Terengganu
        ];

        // Insert data into the institutions table
        DB::table('institutions')->insert($institutions);
    }
}
