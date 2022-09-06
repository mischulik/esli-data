<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $year_start = $this->withFaker()->dateTimeThisCentury();

        return [
            'code' => $this->withFaker()->unique()->randomElement(range(1000, 9999)),
            'name' => $this->withFaker()->company(),
            'year_start' => (int)$year_start->format('Y'),
            'year_end' => $this->withFaker()->dateTimeBetween($year_start)->format('Y'),
        ];
    }
}
