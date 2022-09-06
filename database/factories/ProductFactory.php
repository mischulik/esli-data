<?php

namespace Database\Factories;

use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->withFaker()->sentence(),
            'manufacturer_id' => optional(Manufacturer::query()->inRandomOrder()->first() ?? null, function (Manufacturer $manufacturer) {
                return $manufacturer->id;
            }),
            'stock_code' => strtoupper(str_pad('', 6, $this->withFaker()->randomLetter())),
            'elsie_code' => strtoupper(str_pad('', 6, $this->withFaker()->randomLetter())),
            'width' => $this->withFaker()->randomElement(range(1000, 2000)),
            'height' => $this->withFaker()->randomElement(range(500, 1000)),
        ];
    }
}
