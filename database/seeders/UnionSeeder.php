<?php

namespace Database\Seeders;

use App\Models\Location\Union;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unions = [
            // Khilgoan
            ['id' => '1', 'thana_id' => '1', 'union_name' => 'South Banasree',  'union_slug' => 'south-banasree', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '2', 'thana_id' => '1', 'union_name' => 'Goran',  'union_slug' => 'goran', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '3', 'thana_id' => '1', 'union_name' => 'Boksibug',  'union_slug' => 'boksibug', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '4', 'thana_id' => '1', 'union_name' => 'Hazipara',  'union_slug' => 'hazipara', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '5', 'thana_id' => '1', 'union_name' => 'Trimohani',  'union_slug' => 'trimohani', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '6', 'thana_id' => '1', 'union_name' => 'Madar Tek',  'union_slug' => 'madar-tek', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '7', 'thana_id' => '1', 'union_name' => 'Meradia',  'union_slug' => 'meradia', 'status' => 'active', 'created_at' => Carbon::now()],
            ['id' => '8', 'thana_id' => '1', 'union_name' => 'Taltala',  'union_slug' => 'taltala', 'status' => 'active', 'created_at' => Carbon::now()]
        ];

        Union::truncate();
        Union::insert($unions);
    }
}
