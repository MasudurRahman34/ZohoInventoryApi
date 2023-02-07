<?php

namespace Database\Seeders;

use App\Models\PlanFeaturePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanFeaturePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planFeaturePermissions =
            array(

                array(
                    'plan_id' => 1,
                    'feature_id' => 2,
                    'access' => 'Limit',
                    'access_value' => 2,

                ),
                array(
                    'plan_id' => 2,
                    'feature_id' => 2,
                    'access' => 'Limit',
                    'access_value' => 4,

                ),
                array(
                    'plan_id' => 3,
                    'feature_id' => 2,
                    'access' => 'Limit',
                    'access_value' => 10,

                ),
                array(
                    'plan_id' => 4,
                    'feature_id' => 2,
                    'access' => 'Limit',
                    'access_value' => 15,

                ),
                array(
                    'plan_id' => 1,
                    'feature_id' => 3,
                    'access' => 'No',
                    'access_value' => 0,

                ),
                array(
                    'plan_id' => 2,
                    'feature_id' => 3,
                    'access' => 'Yes',
                    'access_value' => 0,

                ),
                array(
                    'plan_id' => 3,
                    'feature_id' => 3,
                    'access' => 'Yes',
                    'access_value' => 0,

                ),
                array(
                    'plan_id' => 4,
                    'feature_id' => 3,
                    'access' => 'Yes',
                    'access_value' => 0,

                ),
                array(
                    'plan_id' => 1,
                    'feature_id' => 4,
                    'access' => 'Limit',
                    'access_value' => 1,

                ),
                array(
                    'plan_id' => 2,
                    'feature_id' => 4,
                    'access' => 'Limit',
                    'access_value' => 2,
                ),
                array(
                    'plan_id' => 3,
                    'feature_id' => 4,
                    'access' => 'Limit',
                    'access_value' => 5,

                ),
                array(
                    'plan_id' => 4,
                    'feature_id' => 4,
                    'access' => 'limit',
                    'access_value' => 5,

                ),
                array(
                    'plan_id' => 1,
                    'feature_id' => 2,
                    'access' => 'yes',
                    'access_value' => 0,

                ),
                array(
                    'plan_id' => 2,
                    'feature_id' => 2,
                    'access' => 'yes',
                    'access_value' => 0,

                ),
                array(
                    'plan_id' => 3,
                    'feature_id' => 2,
                    'access' => 'yes',
                    'access_value' => 0,

                ),
                array(
                    'plan_id' => 2,
                    'feature_id' => 4,
                    'access' => 'yes',
                    'access_value' => 0,

                ),

            );
        PlanFeaturePermission::truncate();
        PlanFeaturePermission::insert($planFeaturePermissions);
    }
}
