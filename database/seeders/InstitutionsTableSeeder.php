<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $now = Carbon::now();
        
        $institutions = [
           ['name' => 'IPPM', 'state_id' => '10', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Perlis', 'state_id' => '8', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Pusat Koreksional Perlis', 'state_id' => '8', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Kedah', 'state_id' => '2', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Alor Setar', 'state_id' => '2', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Sungai Petani', 'state_id' => '2', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Pokok Sena', 'state_id' => '2', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Akademi Koreksional Malaysia', 'state_id' => '2', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Pulau Pinang', 'state_id' => '9', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Pulau Pinang', 'state_id' => '9', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Seberang Perai', 'state_id' => '9', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Perak', 'state_id' => '7', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Taiping', 'state_id' => '7', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Pusat Koreksional Kamunting', 'state_id' => '7', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PLPP Taiping', 'state_id' => '7', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPA Batu Gajah', 'state_id' => '7', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Tapah', 'state_id' => '7', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Selangor & W.P Kuala Lumpur', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Sungai Buloh', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Kajang', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Maktab Penjara Malaysia', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Wanita Kajang', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Puncak Alam', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Negeri Sembilan', 'state_id' => '5', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Seremban', 'state_id' => '5', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'IPD Jelebu', 'state_id' => '5', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Melaka', 'state_id' => '4', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'SHG Telok Mas', 'state_id' => '4', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Dusun Dato\' Murad', 'state_id' => '4', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Sungai Udang', 'state_id' => '4', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Institut Koreksional Malaysia', 'state_id' => '4', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Muzium Penjara', 'state_id' => '4', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Pusat Koreksional Jasin', 'state_id' => '4', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Johor', 'state_id' => '1', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Johor Bahru', 'state_id' => '1', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Simpang Rengam', 'state_id' => '1', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Pusat Koreksional Muar', 'state_id' => '1', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Kluang', 'state_id' => '1', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Kelantan', 'state_id' => '3', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Pengkalan Chepa', 'state_id' => '3', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPA Machang', 'state_id' => '3', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Terengganu', 'state_id' => '11', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Marang', 'state_id' => '11', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Pusat Koreksional Dungun', 'state_id' => '11', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Pahang', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Penor', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Bentong', 'state_id' => '6', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Sarawak', 'state_id' => '13', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Puncak Borneo', 'state_id' => '13', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Miri', 'state_id' => '13', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Sibu', 'state_id' => '13', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Limbang', 'state_id' => '13', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Bintulu', 'state_id' => '13', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Sri Aman', 'state_id' => '13', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'PPN Sabah', 'state_id' => '12', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Kota Kinabalu', 'state_id' => '12', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Wanita Kota Kinabalu', 'state_id' => '12', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Tawau', 'state_id' => '12', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Sandakan', 'state_id' => '12', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'SHG Keningau', 'state_id' => '12', 'created_at' => $now, 'updated_at' => $now ],
           ['name' => 'Penjara Labuan', 'state_id' => '12', 'created_at' => $now, 'updated_at' => $now ],
        ];

        DB::table('institutions')->insert($institutions);
    }
}
