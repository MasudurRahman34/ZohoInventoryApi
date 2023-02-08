<?php

namespace Database\Seeders;

use App\Models\PriceType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PriceTypes =
            array(
                array(
                    'price_type_name' => 'Monthly',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'price_type_name' => 'Yearly',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'price_type_name' => 'Half Yearly',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),

            );


        PriceType::truncate();
        PriceType::insert($PriceTypes);
    }
}
