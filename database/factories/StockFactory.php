<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
        return [
            'name' => $this->withFaker()->unique()->city(),
            'shop_id' => $this->withFaker()->randomDigitNotNull(),
        ];
    }
}
