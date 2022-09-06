<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'stock_id' => optional(Stock::query()->inRandomOrder()->first() ?? null, function (Stock $stock) {
                return $stock->id;
            }),
            'product_id' => optional(Product::query()->inRandomOrder()->first() ?? null, function (Product $product) {
                return $product->id;
            }),
        ];
    }
}
