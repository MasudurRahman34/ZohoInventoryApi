<?php

namespace Database\Factories;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public $is_serialized = [1, 2];
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'group_id' => random_int(1, 10),
            'item_category' => random_int(1, 10),
            'item_subcategory' => random_int(1, 10),
            'item_company' => random_int(1, 10),
            'brand' => random_int(1, 10),
            'model' => random_int(1, 10),

            'item_name' => $this->faker->word(),
            'item_slug' => Str::slug($this->faker->word()),
            "sku" => $this->faker->word(),
            'universal_product_barcode' => $this->faker->isbn10(),
            'is_serialized' => $this->faker->randomElement(['1', '0']),
            'account_id' => random_int(1, 10),

        ];
    }
}
