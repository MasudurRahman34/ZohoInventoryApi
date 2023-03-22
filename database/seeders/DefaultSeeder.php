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
                array('name' => 'Govt Tax', 'rate' => '15', 'default' => 'Yes'),

            );
        $currencies =
            array(
                array('name' => 'BDT', 'Code' => 'BDT', 'symbol' => 'TK', 'default' => 'Yes'),

            );

        $department =
            array(
                array('name' => 'HR Department', 'default' => 'Yes'),

            );
        $degisnation =
            array(
                array('name' => 'CEO', 'default' => 'Yes'),

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
