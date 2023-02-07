<?php

namespace Database\Seeders;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans =
            array(
                array(
                    'plan_name' => 'Free',
                    'price_monthly' => '0',
                    'price_yearly' => '0',
                    'business_type' => 'Self',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'plan_name' => 'Standard',
                    'price_monthly' => '500',
                    'price_yearly' => '4800',
                    'business_type' => 'Small Business',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'plan_name' => 'Professional',
                    'price_monthly' => '1500',
                    'price_yearly' => '14400',
                    'business_type' => 'Medium Business',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'plan_name' => 'Premium',
                    'price_monthly' => '3000',
                    'price_yearly' => '28800',
                    'business_type' => 'Established Firms',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
            );


        Plan::truncate();
        Plan::insert($plans);
    }
}
