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
           ['name' => 'IPPM', 'state_id' => '10'],
           ['name' => 'PPN Perlis', 'state_id' => '8'],
           ['name' => 'Pusat Koreksional Perlis', 'state_id' => '8'],
           ['name' => 'PPN Kedah', 'state_id' => '2'],
           ['name' => 'Penjara Alor Setar', 'state_id' => '2'],
           ['name' => 'Penjara Sungai Petani', 'state_id' => '2'],
           ['name' => 'Penjara Pokok Sena', 'state_id' => '2'],
           ['name' => 'Akademi Koreksional Malaysia', 'state_id' => '2'],
           ['name' => 'PPN Pulau Pinang', 'state_id' => '9'],
           ['name' => 'Penjara Pulau Pinang', 'state_id' => '9'],
           ['name' => 'Penjara Seberang Perai', 'state_id' => '9'],
           ['name' => 'PPN Perak', 'state_id' => '7'],
           ['name' => 'Penjara Taiping', 'state_id' => '7'],
           ['name' => 'Pusat Koreksional Kamunting', 'state_id' => '7'],
           ['name' => 'PLPP Taiping', 'state_id' => '7'],
           ['name' => 'PPA Batu Gajah', 'state_id' => '7'],
           ['name' => 'Penjara Tapah', 'state_id' => '7'],
           ['name' => 'PPN Selangor & W.P Kuala Lumpur', 'state_id' => '6'],
           ['name' => 'Penjara Sungai Buloh', 'state_id' => '6'],
           ['name' => 'Penjara Kajang', 'state_id' => '6'],
           ['name' => 'Maktab Penjara Malaysia', 'state_id' => '6'],
           ['name' => 'Penjara Wanita Kajang', 'state_id' => '6'],
           ['name' => 'Penjara Puncak Alam', 'state_id' => '6'],
           ['name' => 'PPN Negeri Sembilan', 'state_id' => '5'],
           ['name' => 'Penjara Seremban', 'state_id' => '5'],
           ['name' => 'IPD Jelebu', 'state_id' => '5'],
           ['name' => 'PPN Melaka', 'state_id' => '4'],
           ['name' => 'SHG Telok Mas', 'state_id' => '4'],
           ['name' => 'Penjara Dusun Dato\' Murad', 'state_id' => '4'],
           ['name' => 'Penjara Sungai Udang', 'state_id' => '4'],
           ['name' => 'Institut Koreksional Malaysia', 'state_id' => '4'],
           ['name' => 'Muzium Penjara', 'state_id' => '4'],
           ['name' => 'Pusat Koreksional Jasin', 'state_id' => '4'],
           ['name' => 'PPN Johor', 'state_id' => '1'],
           ['name' => 'Penjara Johor Bahru', 'state_id' => '1'],
           ['name' => 'Penjara Simpang Rengam', 'state_id' => '1'],
           ['name' => 'Pusat Koreksional Muar', 'state_id' => '1'],
           ['name' => 'Penjara Kluang', 'state_id' => '1'],
           ['name' => 'PPN Kelantan', 'state_id' => '3'],
           ['name' => 'Penjara Pengkalan Chepa', 'state_id' => '3'],
           ['name' => 'PPA Machang', 'state_id' => '3'],
           ['name' => 'PPN Terengganu', 'state_id' => '11'],
           ['name' => 'Penjara Marang', 'state_id' => '11'],
           ['name' => 'Pusat Koreksional Dungun', 'state_id' => '11'],
           ['name' => 'PPN Pahang', 'state_id' => '6'],
           ['name' => 'Penjara Penor', 'state_id' => '6'],
           ['name' => 'Penjara Bentong', 'state_id' => '6'],
           ['name' => 'PPN Sarawak', 'state_id' => '13'],
           ['name' => 'Penjara Puncak Borneo', 'state_id' => '13'],
           ['name' => 'Penjara Miri', 'state_id' => '13'],
           ['name' => 'Penjara Sibu', 'state_id' => '13'],
           ['name' => 'Penjara Limbang', 'state_id' => '13'],
           ['name' => 'Penjara Bintulu', 'state_id' => '13'],
           ['name' => 'Penjara Sri Aman', 'state_id' => '13'],
           ['name' => 'PPN Sabah', 'state_id' => '12'],
           ['name' => 'Penjara Kota Kinabalu', 'state_id' => '12'],
           ['name' => 'Penjara Wanita Kota Kinabalu', 'state_id' => '12'],
           ['name' => 'Penjara Tawau', 'state_id' => '12'],
           ['name' => 'Penjara Sandakan', 'state_id' => '12'],
           ['name' => 'SHG Keningau', 'state_id' => '12'],
           ['name' => 'Penjara Labuan', 'state_id' => '12'],
        ];

        foreach ($institutions as &$institution) {
            $institution['created_at'] = $now;
            $institution['updated_at'] = $now;
            $institution['created_by'] = 1;
            $institution['updated_by'] = 1;
        }
        unset($institution);

        DB::table('institutions')->insert($institutions);
    }
}
