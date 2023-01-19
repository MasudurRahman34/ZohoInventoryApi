<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Database\Factories\WareHouseFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Warehouse::factory()->count(10)->create();
    }
}
