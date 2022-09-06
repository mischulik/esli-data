<?php

namespace Database\Factories;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturerFactory extends Factory
{
    protected $model = Manufacturer::class;

    public function definition(): array
    {
        $company = $this->withFaker()->company();

        return [
            'name' => $company,
            'code_suffix' => strtoupper(substr($company, 0, 2)),
            'country' => $this->withFaker()->country(),
        ];
    }
}
