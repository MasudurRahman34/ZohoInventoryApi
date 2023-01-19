<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Stock::class;
    public function definition()
    {
        return [
            'product_id'=>random_int(0,10),
            'warehouse_id' =>random_int(0,10),
            'date' => now(),
            'quantity' =>  '+'.random_int(0,100),
            'purchase_quantity' => '+'.random_int(0,100),
            'sale_quantity' => random_int(1,100),
            'quantity_on_hand' => random_int(1,100),
            'opening_stock_value' => random_int(1,100),
            
        ];
    }
}
