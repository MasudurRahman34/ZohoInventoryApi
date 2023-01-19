<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WareHouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Warehouse::class;
    public function definition()
    {
        return [
            'uuid'=>Str::uuid(),
            'name' =>$this->faker->name(),
            'code' => $this->faker->name(),
            'phone_country_code' =>  '+'.random_int(0,3),
            'mobile_country_code' => '+'.random_int(0,3),
            'phone' => random_int(1,1000000),
            'mobile' => random_int(1,1000000),
            'email' => $this->faker->safeEmail(),
            'description' => $this->faker->text(20),
            'current_balance' => 0,
            
        ];
    }
}
