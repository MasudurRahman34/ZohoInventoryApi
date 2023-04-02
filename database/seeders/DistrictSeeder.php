<?php

namespace Database\Seeders;

use App\Models\Location\District;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = array(
            array('id' => '1', 'state_id' => '1', 'district_name' => 'Dhaka Sadar',  'district_slug' => 'dhaka_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '2', 'state_id' => '1', 'district_name' => 'Narayanganj',  'district_slug' => 'narayanganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '3', 'state_id' => '1', 'district_name' => 'Gazipur',  'district_slug' => 'gazipur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '4', 'state_id' => '1', 'district_name' => 'Faridpur',  'district_slug' => 'faridpur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '5', 'state_id' => '1', 'district_name' => 'Kishoreganj',  'district_slug' => 'kishoreganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '6', 'state_id' => '1', 'district_name' => 'Munshiganj',  'district_slug' => 'munshiganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '7', 'state_id' => '1', 'district_name' => 'Narsingdi',  'district_slug' => 'narsingdi', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '8', 'state_id' => '1', 'district_name' => 'Tangail',  'district_slug' => 'tangail', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '9', 'state_id' => '1', 'district_name' => 'Gopalganj',  'district_slug' => 'gopalganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '10', 'state_id' => '1', 'district_name' => 'Madaripur',  'district_slug' => 'madaripur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '11', 'state_id' => '1', 'district_name' => 'Gopalganj',  'district_slug' => 'gopalganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '12', 'state_id' => '1', 'district_name' => 'Rajbari',  'district_slug' => 'rajbari', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '13', 'state_id' => '1', 'district_name' => 'Shariatpur',  'district_slug' => 'shariatpur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '14', 'state_id' => '1', 'district_name' => 'Manikganj',  'district_slug' => 'manikganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '15', 'state_id' => '1', 'district_name' => 'Shariatpur',  'district_slug' => 'shariatpur', 'status' => 'active', 'created_at' => Carbon::now()),

            array('id' => '16', 'state_id' => '2', 'district_name' => 'Bagerhat',  'district_slug' => 'bagerhat', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '17', 'state_id' => '2', 'district_name' => 'Chuadanga',  'district_slug' => 'chuadanga', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '18', 'state_id' => '2', 'district_name' => 'Jessore',  'district_slug' => 'jessore', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '19', 'state_id' => '2', 'district_name' => 'Jhenaida',  'district_slug' => 'jhenaida', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '20', 'state_id' => '2', 'district_name' => 'Khulna Sadar',  'district_slug' => 'khulna_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '21', 'state_id' => '2', 'district_name' => 'Kushtia',  'district_slug' => 'kushtia', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '22', 'state_id' => '2', 'district_name' => 'Magura',  'district_slug' => 'magura', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '23', 'state_id' => '2', 'district_name' => 'Meherpur',  'district_slug' => 'meherpur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '24', 'state_id' => '2', 'district_name' => 'Narail',  'district_slug' => 'narail', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '25', 'state_id' => '2', 'district_name' => 'Satkhira',  'district_slug' => 'satkhira', 'status' => 'active', 'created_at' => Carbon::now()),

            array('id' => '26', 'state_id' => '3', 'district_name' => 'Barguna',  'district_slug' => 'barguna', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '27', 'state_id' => '3', 'district_name' => 'Barisal Sadar',  'district_slug' => 'barisal_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '28', 'state_id' => '3', 'district_name' => 'Bhola',  'district_slug' => 'bhola', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '29', 'state_id' => '3', 'district_name' => 'Jhalokathi',  'district_slug' => 'jhalokathi', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '30', 'state_id' => '3', 'district_name' => 'Patuakhali',  'district_slug' => 'patuakhali', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '31', 'state_id' => '3', 'district_name' => 'Pirojpur',  'district_slug' => 'pirojpur', 'status' => 'active', 'created_at' => Carbon::now()),

            array('id' => '32', 'state_id' => '4', 'district_name' => 'Bandarban',  'district_slug' => 'bandarban', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '33', 'state_id' => '4', 'district_name' => 'Brahmanbaria',  'district_slug' => 'brahmanbaria', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '34', 'state_id' => '4', 'district_name' => 'Chandpur',  'district_slug' => 'chandpur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '35', 'state_id' => '4', 'district_name' => 'Chittagong Sadar',  'district_slug' => 'chittagong_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '36', 'state_id' => '4', 'district_name' => 'Comilla',  'district_slug' => 'comilla', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '37', 'state_id' => '4', 'district_name' => 'Cox\'s Bazar',  'district_slug' => 'coxs_bazar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '38', 'state_id' => '4', 'district_name' => 'Feni',  'district_slug' => 'feni', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '39', 'state_id' => '4', 'district_name' => 'Khagrachhari',  'district_slug' => 'khagrachhari', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '40', 'state_id' => '4', 'district_name' => 'Lakshmipur',  'district_slug' => 'lakshmipur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '41', 'state_id' => '4', 'district_name' => 'Noakhali',  'district_slug' => 'noakhali', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '42', 'state_id' => '4', 'district_name' => 'Rangamati',  'district_slug' => 'rangamati', 'status' => 'active', 'created_at' => Carbon::now()),

            array('id' => '43', 'state_id' => '5', 'district_name' => 'Dinajpur',  'district_slug' => 'dinajpur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '44', 'state_id' => '5', 'district_name' => 'Gaibandha',  'district_slug' => 'gaibandha', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '45', 'state_id' => '5', 'district_name' => 'Kurigram',  'district_slug' => 'kurigram', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '46', 'state_id' => '5', 'district_name' => 'Lalmonirhat',  'district_slug' => 'lalmonirhat', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '47', 'state_id' => '5', 'district_name' => 'Nilphamari',  'district_slug' => 'nilphamari', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '48', 'state_id' => '5', 'district_name' => 'Panchagarh',  'district_slug' => 'panchagarh', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '49', 'state_id' => '5', 'district_name' => 'Rangpur Sadar',  'district_slug' => 'rangpur_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '50', 'state_id' => '5', 'district_name' => 'Thakurgaon',  'district_slug' => 'thakurgaon', 'status' => 'active', 'created_at' => Carbon::now()),

            array('id' => '51', 'state_id' => '6', 'district_name' => 'Bogra',  'district_slug' => 'bogra', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '52', 'state_id' => '6', 'district_name' => 'Joypurhat',  'district_slug' => 'joypurhat', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '53', 'state_id' => '6', 'district_name' => 'Naogaon',  'district_slug' => 'naogaon', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '54', 'state_id' => '6', 'district_name' => 'Natore',  'district_slug' => 'natore', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '55', 'state_id' => '6', 'district_name' => 'Chapai Nawabganj',  'district_slug' => 'chapai_nawabganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '56', 'state_id' => '6', 'district_name' => 'Pabna',  'district_slug' => 'pabna', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '57', 'state_id' => '6', 'district_name' => 'Rajshahi Sadar',  'district_slug' => 'rajshahi_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '58', 'state_id' => '6', 'district_name' => 'Sirajganj',  'district_slug' => 'sirajganj', 'status' => 'active', 'created_at' => Carbon::now()),

            array('id' => '59', 'state_id' => '7', 'district_name' => 'Jamalpur',  'district_slug' => 'jamalpur', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '60', 'state_id' => '7', 'district_name' => 'Mymensingh Sadar',  'district_slug' => 'mymensingh_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '61', 'state_id' => '7', 'district_name' => 'Netrokona',  'district_slug' => 'netrokona', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '62', 'state_id' => '7', 'district_name' => 'Sherpur',  'district_slug' => 'sherpur', 'status' => 'active', 'created_at' => Carbon::now()),

            array('id' => '63', 'state_id' => '8', 'district_name' => 'Habiganj',  'district_slug' => 'habiganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '64', 'state_id' => '8', 'district_name' => 'Moulvibazar',  'district_slug' => 'moulvibazar', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '65', 'state_id' => '8', 'district_name' => 'Sunamganj',  'district_slug' => 'sunamganj', 'status' => 'active', 'created_at' => Carbon::now()),
            array('id' => '66', 'state_id' => '8', 'district_name' => 'Sylhet Sadar',  'district_slug' => 'sylhet_sadar', 'status' => 'active', 'created_at' => Carbon::now()),
        );

        District::truncate();
        District::insert($districts);
    }
}
