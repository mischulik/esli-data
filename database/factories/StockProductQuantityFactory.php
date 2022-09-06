<?php

namespace Database\Factories;

use App\Models\StockProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockProductQuantityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'stock_product_id' => optional(StockProduct::query()->inRandomOrder()->first() ?? null, function (StockProduct $stockProduct) {
                return $stockProduct->id;
            }),
            'quantity' => $this->withFaker()->randomDigitNotNull(),
        ];
    }
}
