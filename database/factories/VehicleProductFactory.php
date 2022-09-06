<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Vehicle;
use App\Models\VehicleProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleProductFactory extends Factory
{
    protected $model = VehicleProduct::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => optional(Vehicle::query()->inRandomOrder()->first() ?? null, function (Vehicle $vehicle) {
                return $vehicle->id;
            }),
            'product_id' => optional(Product::query()->inRandomOrder()->first() ?? null, function (Product $product) {
                return $product->id;
            }),
        ];
    }
}
