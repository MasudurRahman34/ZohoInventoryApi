<?php

namespace Database\Seeders;

use App\Models\Location\Thana;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thanas = [
            // Dhaka Sodor
            ['id' => '1', 'district_id' => '1', 'thana_name' => 'Khilgoan',  'thana_slug' => 'khilgoan', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '2', 'district_id' => '1', 'thana_name' => 'Rampura',  'thana_slug' => 'rampura', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '3', 'district_id' => '1', 'thana_name' => 'Adabor',  'thana_slug' => 'adabor', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '4', 'district_id' => '1', 'thana_name' => 'Azampur',  'thana_slug' => 'azampur', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '5', 'district_id' => '1', 'thana_name' => 'Badda',  'thana_slug' => 'badda', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '6', 'district_id' => '1', 'thana_name' => 'Bangsal',  'thana_slug' => 'bangsal', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '7', 'district_id' => '1', 'thana_name' => 'Cantonment',  'thana_slug' => 'cantonment', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '8', 'district_id' => '1', 'thana_name' => 'Chowkbazar',  'thana_slug' => 'chowkbazar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '9', 'district_id' => '1', 'thana_name' => 'Demra',  'thana_slug' => 'demra', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '10', 'district_id' => '1', 'thana_name' => 'Dhanmondi',  'thana_slug' => 'dhanmondi', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '11', 'district_id' => '1', 'thana_name' => 'Gendaria',  'thana_slug' => 'gendaria', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '12', 'district_id' => '1', 'thana_name' => 'Gulshan',  'thana_slug' => 'gulshan', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '13', 'district_id' => '1', 'thana_name' => 'Hazaribagh',  'thana_slug' => 'hazaribagh', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '14', 'district_id' => '1', 'thana_name' => 'Kadamtali',  'thana_slug' => 'kadamtali', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '15', 'district_id' => '1', 'thana_name' => 'Kafrul',  'thana_slug' => 'kafrul', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '16', 'district_id' => '1', 'thana_name' => 'Kalabagan',  'thana_slug' => 'kalabagan', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '17', 'district_id' => '1', 'thana_name' => 'Kamrangirchar',  'thana_slug' => 'kamrangirchar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '18', 'district_id' => '1', 'thana_name' => 'Khilkhet',  'thana_slug' => 'khilkhet', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '19', 'district_id' => '1', 'thana_name' => 'Kotwali',  'thana_slug' => 'kotwali', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '20', 'district_id' => '1', 'thana_name' => 'Kadamtali',  'thana_slug' => 'kadamtali', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '21', 'district_id' => '1', 'thana_name' => 'Lalbagh',  'thana_slug' => 'lalbagh', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '22', 'district_id' => '1', 'thana_name' => 'Mirpur Model',  'thana_slug' => 'mirpur-model', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '23', 'district_id' => '1', 'thana_name' => 'Mohammadpur',  'thana_slug' => 'mohammadpur', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '24', 'district_id' => '1', 'thana_name' => 'Motijheel',  'thana_slug' => 'motijheel', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '25', 'district_id' => '1', 'thana_name' => 'New Market',  'thana_slug' => 'new-market', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '26', 'district_id' => '1', 'thana_name' => 'Pallabi',  'thana_slug' => 'pallabi', 'status' => 'active', 'created_at' => Carbon::now()],

            //Narayanganj
            ['id' => '27', 'district_id' => '2', 'thana_name' => 'Gomastapur',  'thana_slug' => 'gomastapur', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '28', 'district_id' => '2', 'thana_name' => 'Nawabganj Sadar',  'thana_slug' => 'nawabganj-sadar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '29', 'district_id' => '2', 'thana_name' => 'Nachole',  'thana_slug' => 'nachole', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '30', 'district_id' => '2', 'thana_name' => 'Bholahat',  'thana_slug' => 'bholahat', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '31', 'district_id' => '2', 'thana_name' => 'Shibganj',  'thana_slug' => 'shibganj', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '32', 'district_id' => '2', 'thana_name' => 'Araihazar',  'thana_slug' => 'araihazar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '33', 'district_id' => '2', 'thana_name' => 'Rupganj',  'thana_slug' => 'rupganj', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '34', 'district_id' => '2', 'thana_name' => 'Bandar',  'thana_slug' => 'bandar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '35', 'district_id' => '2', 'thana_name' => 'Sonargaon',  'thana_slug' => 'sonargaon', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '36', 'district_id' => '2', 'thana_name' => 'Narayanganj',  'thana_slug' => 'narayanganj', 'status' => 'active', 'created_at' => Carbon::now()],

            //Gazipur
            ['id' => '37', 'district_id' => '3', 'thana_name' => 'Kapasia',  'thana_slug' => 'kapasia', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '38', 'district_id' => '3', 'thana_name' => 'Kaliakair',  'thana_slug' => 'kaliakair', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '39', 'district_id' => '3', 'thana_name' => 'Gazipur Sadar',  'thana_slug' => 'gazipur-sadar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '40', 'district_id' => '3', 'thana_name' => 'Sreepur',  'thana_slug' => 'sreepur', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '41', 'district_id' => '3', 'thana_name' => 'Kaliganj',  'thana_slug' => 'kaliganj', 'status' => 'active', 'created_at' => Carbon::now()],

            //Faridpur
            ['id' => '42', 'district_id' => '4', 'thana_name' => 'Alfadanga',  'thana_slug' => 'alfadanga', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '43', 'district_id' => '4', 'thana_name' => 'Char Bhadrasan',  'thana_slug' => 'char-bhadrasan', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '44', 'district_id' => '4', 'thana_name' => 'Nagarkanda',  'thana_slug' => 'nagarkanda', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '45', 'district_id' => '4', 'thana_name' => 'Faridpur Sadar',  'thana_slug' => 'faridpur-sadar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '46', 'district_id' => '4', 'thana_name' => 'Boalmari',  'thana_slug' => 'boalmari', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '47', 'district_id' => '4', 'thana_name' => 'Bhanga',  'thana_slug' => 'bhanga', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '48', 'district_id' => '4', 'thana_name' => 'Madhukhali',  'thana_slug' => 'madhukhali', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '49', 'district_id' => '4', 'thana_name' => 'Sadarpur',  'thana_slug' => 'sadarpur', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '50', 'district_id' => '4', 'thana_name' => 'Saltha',  'thana_slug' => 'saltha', 'status' => 'active', 'created_at' => Carbon::now()],

            //Kishoreganj
            ['id' => '51', 'district_id' => '5', 'thana_name' => 'Austagram',  'thana_slug' => 'austagram', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '52', 'district_id' => '5', 'thana_name' => 'Itna',  'thana_slug' => 'itna', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '53', 'district_id' => '5', 'thana_name' => 'Katiadi',  'thana_slug' => 'katiadi', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '54', 'district_id' => '5', 'thana_name' => 'Karimganj',  'thana_slug' => 'karimganj', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '55', 'district_id' => '5', 'thana_name' => 'Kishoreganj Sadar',  'thana_slug' => 'kishoreganj-sadar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '56', 'district_id' => '5', 'thana_name' => 'Kuliarchar',  'thana_slug' => 'kuliarchar', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '57', 'district_id' => '5', 'thana_name' => 'Nikli',  'thana_slug' => 'nikli', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '58', 'district_id' => '5', 'thana_name' => 'Pakundia',  'thana_slug' => 'pakundia', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '59', 'district_id' => '5', 'thana_name' => 'Bajitpur',  'thana_slug' => 'bajitpur', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '60', 'district_id' => '5', 'thana_name' => 'Bhairab',  'thana_slug' => 'bhairab', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '61', 'district_id' => '5', 'thana_name' => 'Mithamain',  'thana_slug' => 'mithamain', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '62', 'district_id' => '5', 'thana_name' => 'Hossainpur',  'thana_slug' => 'hossainpur', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '63', 'district_id' => '5', 'thana_name' => 'Tarail',  'thana_slug' => 'tarail', 'status' => 'active', 'created_at' => Carbon::now()],
        ];

        Thana::truncate();
        Thana::insert($thanas);
    }
}
