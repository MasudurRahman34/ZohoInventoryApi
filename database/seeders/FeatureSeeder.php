<?php

namespace Database\Seeders;

use App\Models\Feature;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features =
            array(
                array(
                    'name' => 'Applicaiton Feature',
                    'parent_id' => '0',
                    'status' => '1',

                ),
                array(
                    'name' => 'User',
                    'parent_id' => '1',
                    'status' => '1',

                ),
                array(
                    'name' => 'User Restriction',
                    'parent_id' => '1',
                    'status' => '1',

                ),
                array(
                    'name' => 'Warehouse',
                    'parent_id' => '1',
                    'status' => '1',

                ),
                array(
                    'name' => 'Product Features',
                    'parent_id' => '0',
                    'status' => '1',

                ),
                array(
                    'name' => 'Manage items group',
                    'parent_id' => '2',
                    'status' => '1',

                ),
                array(
                    'name' => 'Serialized Item',
                    'parent_id' => '2',
                    'status' => '1',

                ),
                array(
                    'name' => 'item Inventory History',
                    'parent_id' => '2',
                    'status' => '1',

                ),
                array(
                    'name' => 'Sale Feature',
                    'parent_id' => '0',
                    'status' => '1',

                ),
                array(
                    'name' => 'Sales Order Per Month',
                    'parent_id' => '3',
                    'status' => '1',

                ),
                array(
                    'name' => 'invoice Per Month',
                    'parent_id' => '3',
                    'status' => '1',

                ),

            );


        Feature::truncate();
        Feature::insert($features);
    }
}
