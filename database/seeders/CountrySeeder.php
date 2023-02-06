<?php

namespace Database\Seeders;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = array(
            array('id' => '1', 'country_name' => 'Andorra', 'country_slug' => 'andorra', 'iso2' => 'AD', 'iso3' => 'AND', 'calling_code' => '93',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '2', 'country_name' => 'United Arab Emirates', 'country_slug' => 'united-arab-emirates', 'iso2' => 'AE', 'iso3' => 'ARE', 'calling_code' => '971', 'currency' => '',  'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '3', 'country_name' => 'Afghanistan', 'country_slug' => 'afghanistan', 'iso2' => 'AF', 'iso3' => 'AFG', 'calling_code' => '93',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '4', 'country_name' => 'Antigua and Barbuda', 'country_slug' => 'antigua-and-barbuda', 'iso2' => 'AG', 'iso3' => 'ATG', 'calling_code' => '1268', 'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '5', 'country_name' => 'Anguilla', 'country_slug' => 'anguilla', 'iso2' => 'AI', 'iso3' => 'AIA', 'calling_code' => '1264', 'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '6', 'country_name' => 'Albania', 'country_slug' => 'albania', 'iso2' => 'AL', 'iso3' => 'ALB', 'calling_code' => '355', 'currency' => '',  'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '7', 'country_name' => 'Armenia', 'country_slug' => 'Armenia', 'iso2' => 'AM', 'iso3' => 'ARM', 'calling_code' => '374', 'currency' => '',  'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '8', 'country_name' => 'Angola', 'country_slug' => 'angola', 'iso2' => 'AO', 'iso3' => 'AGO', 'calling_code' => '244', 'currency' => '',  'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '9', 'country_name' => 'Antarctica', 'country_slug' => 'antarctica', 'iso2' => 'AQ', 'iso3' => 'ATA', 'calling_code' => '672', 'currency' => '',  'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '10', 'country_name' => 'Argentina', 'country_slug' => 'argentina', 'iso2' => 'AR', 'iso3' => 'ARG', 'calling_code' => '54',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '11', 'country_name' => 'American Samoa', 'country_slug' => 'american-samoa', 'iso2' => 'AS', 'iso3' => 'ASM', 'calling_code' => '1684',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '12', 'country_name' => 'Austria', 'country_slug' => 'austria', 'iso2' => 'AT', 'iso3' => 'AUT', 'calling_code' => '43',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '14', 'country_name' => 'Aruba', 'country_slug' => 'aruba', 'iso2' => 'AW', 'iso3' => 'ABW', 'calling_code' => '297',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '16', 'country_name' => 'Azerbaijan', 'country_slug' => 'azerbaijan', 'iso2' => 'AZ', 'iso3' => 'AZE', 'calling_code' => '994',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '17', 'country_name' => 'Bosnia-Herzegovina', 'country_slug' => 'bosnia-herzegovina', 'iso2' => 'BA', 'iso3' => 'BIH', 'calling_code' => '387',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '18', 'country_name' => 'Barbados', 'country_slug' => 'barbados', 'iso2' => 'BB', 'iso3' => 'BRB', 'calling_code' => '1246',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
            array('id' => '19', 'country_name' => 'Bangladesh', 'country_slug' => 'bangladesh', 'iso2' => 'BD', 'iso3' => 'BGD', 'calling_code' => '880',  'currency' => '', 'status' => '1', 'created_at' => Carbon::now(), 'updated_at' => NULL),
        );

        Country::truncate();
        Country::insert($countries);
    }
}
