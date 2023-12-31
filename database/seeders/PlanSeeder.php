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
                    'business_type' => 'Personal',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'plan_name' => 'Standard',
                    'business_type' => 'Small Business',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'plan_name' => 'Professional',
                    'business_type' => 'Medium Business',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ),
                array(
                    'plan_name' => 'Premium',
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
