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
            ['name' => 'Penjara Kajang', 'state_id' => 12, 'description' => "Sungai Jelok, 43000 Kajang, SELANGOR DARUL EHSAN"],  // Selangor
            ['name' => 'Penjara Sungai Buloh', 'state_id' => 12, 'description' => "Penjara Sungai Buloh, 47000 Sungai Buloh, Selangor"],  // Selangor
            ['name' => 'Penjara Johor Bahru', 'state_id' => 1, 'description' => "KM 3, Jalan Johor Baru-Pontian, Kangkar Pulai, 81300 Skudai, Johor"],  // Johor
            ['name' => 'Penjara Kluang', 'state_id' => 1, 'description' => "Batu 8, Jalan Mersing, 86000 Kluang, JOHOR DARUL TAKZIM"],  // Johor
            ['name' => 'Penjara Alor Setar', 'state_id' => 2, 'description' => "Jalan Sultanah, 05350 Alor Setar, KEDAH DARUL AMAN"],  // Kedah
            ['name' => 'Penjara Pengkalan Chepa', 'state_id' => 3, 'description' => "Jalan Maktab, 16109 Pengkalan Chepa, KELANTAN DARUL NAIM"],  // Kelantan
            ['name' => 'Penjara Melaka', 'state_id' => 4, 'description' => "Jalan Parameswara 75000 Banda Hilir, MELAKA"],  // Melaka
            ['name' => 'Penjara Seremban', 'state_id' => 5, 'description' => "Jalan Muthu Cumaru, 70990 Seremban, NEGERI SEMBILAN DARUL KHUSUS"],  // Negeri Sembilan
            ['name' => 'Penjara Bentong', 'state_id' => 6, 'description' => "Kompleks Penjara Bentong, Mempaga, 28600 Karak, Bentong, PAHANG DARUL MAKMUR"],  // Pahang
            ['name' => 'Penjara Taiping', 'state_id' => 7, 'description' => "Jalan Taming Sari, 34000 Taiping, PERAK DARUL RIDZUAN"],  // Perak
            ['name' => 'Penjara Kangar', 'state_id' => 8, 'description' => "Jalan Kok Klang, 02500 Mata Ayer, Kangar, PERLIS"],  // Perlis
            ['name' => 'Penjara Seberang Perai', 'state_id' => 9, 'description' => "Kompleks Penjara Seberang Perai,Jalan Kerian Kedah, 14200 Sungai Jawi, Seberang Perai Selatan, PULAU PINANG"],  // Pulau Pinang
            ['name' => 'Penjara Kota Kinabalu', 'state_id' => 10, 'description' => "Peti Surat 11020, 88811 Kota Kinabalu, SABAH"],  // Sabah
            ['name' => 'Penjara Kuching', 'state_id' => 11, 'description' => "Penjara Puncak Borneo KM 23, Jalan Puncak Borneo, 93250 Kuching, Sarawak"],  // Sarawak
            ['name' => 'Penjara Marang', 'state_id' => 13, 'description' => "Mukim 21600 Kampung Kuala Tengah, 21600 Marang, Terengganu"],  // Terengganu
        ];

        // Insert data into the institutions table
        DB::table('institutions')->insert($institutions);
    }
}
