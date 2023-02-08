<?php

namespace Database\Seeders;

use App\Models\PlanPrice;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanPriceSeeder extends Seeder
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
                array('plan_id' => '1', 'price_types_id' => '1', 'amount' => 0, 'currency' => NULL, 'created_at' => Carbon::now(), 'updated_at' => NULL),
                array('plan_id' => '1', 'price_types_id' => '2', 'amount' => 0, 'currency' => NULL, 'created_at' => Carbon::now(), 'updated_at' => NULL),
                array('plan_id' => '2', 'price_types_id' => '1', 'amount' => 500, 'currency' => "BDT", 'created_at' => Carbon::now(), 'updated_at' => NULL),
                array('plan_id' => '2', 'price_types_id' => '2', 'amount' => 4800, 'currency' => 'BDT', 'created_at' => Carbon::now(), 'updated_at' => NULL),
                array('plan_id' => '3', 'price_types_id' => '1', 'amount' => 1500, 'currency' => 'BDT', 'created_at' => Carbon::now(), 'updated_at' => NULL),
                array('plan_id' => '3', 'price_types_id' => '2', 'amount' => 14400, 'currency' => 'BDT', 'created_at' => Carbon::now(), 'updated_at' => NULL),
                array('plan_id' => '4', 'price_types_id' => '1', 'amount' => 3000, 'currency' => 'BDT', 'created_at' => Carbon::now(), 'updated_at' => NULL),
                array('plan_id' => '4', 'price_types_id' => '2', 'amount' => 28800, 'currency' => 'BDT', 'created_at' => Carbon::now(), 'updated_at' => NULL),

            );


        PlanPrice::truncate();
        PlanPrice::insert($PriceTypes);
    }
}
