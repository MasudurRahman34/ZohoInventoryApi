<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxData =
            array(
                array('name' => 'Govt Tax', 'rate' => '15', 'status' => 'active', 'default' => 'yes'),

            );
        $currencies =
            array(
                array('name' => 'BDT', 'Code' => 'BDT', 'symbol' => 'TK', 'status' => 'active', 'default' => 'yes'),
                array('name' => 'USD', 'Code' => 'US', 'symbol' => '$', 'status' => 'active', 'default' => 'yes'),
            );

        $department =
            array(
                array('name' => 'HR', 'status' => 'active', 'default' => 'yes'),
                array('name' => 'Accounts', 'status' => 'active', 'default' => 'yes'),
            );
        $degisnation =
            array(
                array('name' => 'CEO', 'status' => 'active', 'default' => 'yes'),

            );

        Tax::truncate();
        Tax::insert($taxData);

        Currency::truncate();
        Currency::insert($currencies);

        Department::truncate();
        Department::insert($department);

        Designation::truncate();
        Designation::insert($degisnation);
    }
}
