<?php

namespace Database\Seeders;

use App\Models\PlanFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planFeature =
            array(

                array('plan_id' => 1, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 2,),
                array('plan_id' => 2, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 4,),
                array('plan_id' => 3, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 10,),
                array('plan_id' => 4, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 15,),

                array('plan_id' => 1, 'feature_id' => 3, 'access' => 'No', 'access_value' => "No",),
                array('plan_id' => 2, 'feature_id' => 3, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 3, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 3, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 1,),
                array('plan_id' => 2, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 2),
                array('plan_id' => 3, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 5,),
                array('plan_id' => 4, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 7,),

                array('plan_id' => 1, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 1,),
                array('plan_id' => 2, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 2),
                array('plan_id' => 3, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 5,),
                array('plan_id' => 4, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 7,),

                //Product Features

                array('plan_id' => 1, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => "Yes",),


                //Sales Feature

                array('plan_id' => 1, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 50,),
                array('plan_id' => 2, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 1500,),
                array('plan_id' => 3, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 3500,),
                array('plan_id' => 4, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 7000,),

                array('plan_id' => 1, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 50,),
                array('plan_id' => 2, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 1500,),
                array('plan_id' => 3, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 3500,),
                array('plan_id' => 4, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 7000,),

                array('plan_id' => 1, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 21, 'access' => 'No', 'access_value' => "No",),
                array('plan_id' => 2, 'feature_id' => 21, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 21, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 21, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 22, 'access' => 'No', 'access_value' => "No",),
                array('plan_id' => 2, 'feature_id' => 22, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 22, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 22, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => "Yes",),

                //Purchase Features
                array('plan_id' => 1, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 20,),
                array('plan_id' => 2, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 500,),
                array('plan_id' => 3, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 1200,),
                array('plan_id' => 4, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 2500,),

                array('plan_id' => 1, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 20,),
                array('plan_id' => 2, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 500,),
                array('plan_id' => 3, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 1200,),
                array('plan_id' => 4, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 2500,),

                array('plan_id' => 1, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => "Yes",),

                //Add On Options
                array('plan_id' => 1, 'feature_id' => 32, 'access' => 'No', 'access_value' => "No",),
                array('plan_id' => 2, 'feature_id' => 32, 'access' => 'Limit', 'access_value' => '150BDT',),

                array('plan_id' => 1, 'feature_id' => 33, 'access' => 'No', 'access_value' => "No",),
                array('plan_id' => 2, 'feature_id' => 33, 'access' => 'Limit', 'access_value' => '290BDT per month 2780BDT per year',),
                array('plan_id' => 3, 'feature_id' => 33, 'access' => 'Limit', 'access_value' => '290BDT per month 2780BDT per year',),
                array('plan_id' => 4, 'feature_id' => 33, 'access' => 'Limit', 'access_value' => '290BDT per month 2780BDT per year',),

                array('plan_id' => 1, 'feature_id' => 34, 'access' => 'No', 'access_value' => "No",),
                array('plan_id' => 2, 'feature_id' => 34, 'access' => 'Limit', 'access_value' => '190BDT per month 1824BDT per year',),
                array('plan_id' => 3, 'feature_id' => 34, 'access' => 'Limit', 'access_value' => '190BDT per month 1824BDT per year',),
                array('plan_id' => 4, 'feature_id' => 34, 'access' => 'Limit', 'access_value' => '190BDT per month 1824BDT per year',),

                //Mobile App
                array('plan_id' => 1, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => "Yes",),

                //Reminder and Notifications
                array('plan_id' => 1, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => "Yes",),
                //Support
                array('plan_id' => 1, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => "Yes",),

                array('plan_id' => 1, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 2, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 3, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => "Yes",),
                array('plan_id' => 4, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => "Yes",),

                //Application Features

                // array('plan_id' => 1, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 2,),
                // array('plan_id' => 2, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 4,),
                // array('plan_id' => 3, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 10,),
                // array('plan_id' => 4, 'feature_id' => 2, 'access' => 'Limit', 'access_value' => 15,),

                // array('plan_id' => 1, 'feature_id' => 3, 'access' => 'No', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 3, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 3, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 3, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 1,),
                // array('plan_id' => 2, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 2),
                // array('plan_id' => 3, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 5,),
                // array('plan_id' => 4, 'feature_id' => 4, 'access' => 'Limit', 'access_value' => 7,),

                // array('plan_id' => 1, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 1,),
                // array('plan_id' => 2, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 2),
                // array('plan_id' => 3, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 5,),
                // array('plan_id' => 4, 'feature_id' => 5, 'access' => 'Limit', 'access_value' => 7,),

                // //Product Features

                // array('plan_id' => 1, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 7, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 8, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 9, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 10, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 11, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 12, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 13, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 14, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 15, 'access' => 'Yes', 'access_value' => 0,),


                // //Sales Feature

                // array('plan_id' => 1, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 50,),
                // array('plan_id' => 2, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 1500,),
                // array('plan_id' => 3, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 3500,),
                // array('plan_id' => 4, 'feature_id' => 17, 'access' => 'Limit', 'access_value' => 7000,),

                // array('plan_id' => 1, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 50,),
                // array('plan_id' => 2, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 1500,),
                // array('plan_id' => 3, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 3500,),
                // array('plan_id' => 4, 'feature_id' => 18, 'access' => 'Limit', 'access_value' => 7000,),

                // array('plan_id' => 1, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 19, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 20, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 21, 'access' => 'No', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 21, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 21, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 21, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 22, 'access' => 'No', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 22, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 22, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 22, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 23, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 24, 'access' => 'Yes', 'access_value' => 0,),

                // //Purchase Features
                // array('plan_id' => 1, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 20,),
                // array('plan_id' => 2, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 500,),
                // array('plan_id' => 3, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 1200,),
                // array('plan_id' => 4, 'feature_id' => 26, 'access' => 'Limit', 'access_value' => 2500,),

                // array('plan_id' => 1, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 20,),
                // array('plan_id' => 2, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 500,),
                // array('plan_id' => 3, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 1200,),
                // array('plan_id' => 4, 'feature_id' => 27, 'access' => 'Limit', 'access_value' => 2500,),

                // array('plan_id' => 1, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 28, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 29, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 30, 'access' => 'Yes', 'access_value' => 0,),

                // //Add On Options
                // array('plan_id' => 1, 'feature_id' => 32, 'access' => 'No', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 32, 'access' => 'Limit', 'access_value' => '150BDT',),

                // array('plan_id' => 1, 'feature_id' => 33, 'access' => 'No', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 33, 'access' => 'Limit', 'access_value' => '290BDT per month 2780BDT per year',),
                // array('plan_id' => 3, 'feature_id' => 33, 'access' => 'Limit', 'access_value' => '290BDT per month 2780BDT per year',),
                // array('plan_id' => 4, 'feature_id' => 33, 'access' => 'Limit', 'access_value' => '290BDT per month 2780BDT per year',),

                // array('plan_id' => 1, 'feature_id' => 34, 'access' => 'No', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 34, 'access' => 'Limit', 'access_value' => '190BDT per month 1824BDT per year',),
                // array('plan_id' => 3, 'feature_id' => 34, 'access' => 'Limit', 'access_value' => '190BDT per month 1824BDT per year',),
                // array('plan_id' => 4, 'feature_id' => 34, 'access' => 'Limit', 'access_value' => '190BDT per month 1824BDT per year',),

                // //Mobile App
                // array('plan_id' => 1, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 36, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 37, 'access' => 'Yes', 'access_value' => 0,),

                // //Reminder and Notifications
                // array('plan_id' => 1, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 39, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 40, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 41, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 42, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 43, 'access' => 'Yes', 'access_value' => 0,),
                // //Support
                // array('plan_id' => 1, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 45, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 46, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 47, 'access' => 'Yes', 'access_value' => 0,),

                // array('plan_id' => 1, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 2, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 3, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => 0,),
                // array('plan_id' => 4, 'feature_id' => 48, 'access' => 'Yes', 'access_value' => 0,),

            );
        PlanFeature::truncate();
        PlanFeature::insert($planFeature);
    }
}
