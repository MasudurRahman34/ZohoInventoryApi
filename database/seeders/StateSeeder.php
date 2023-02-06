<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Location\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = array(
            array('id' => '1', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Dhaka',  'state_slug' => 'dhaka', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '2', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Khulna',  'state_slug' => 'khulna', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '3', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Barisal',  'state_slug' => 'barisal', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '4', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Chittagong',  'state_slug' => 'chittagong', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '5', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Rangpur',  'state_slug' => 'rangpur', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '6', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Rajshahi',  'state_slug' => 'rajshahi', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '7', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Mymensingh',  'state_slug' => 'mymensingh', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '8', 'country_iso2' => 'BD', 'country_iso3' => 'BGD', 'state_name' => 'Sylhet',  'state_slug' => 'sylhet', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
        );

        State::truncate();
        State::insert($states);
    }
}
