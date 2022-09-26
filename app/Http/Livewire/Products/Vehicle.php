<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class Vehicle extends Component
{
    public \App\Models\Vehicle $vehicle;

    public function render()
    {
        return view('products.vehicle');
    }
}
