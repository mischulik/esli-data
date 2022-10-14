<?php

namespace App\Http\Livewire\Products;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Vehicle extends Component
{
    public \App\Models\Vehicle $vehicle;

    public function render(): Factory|View|Application
    {
        return view('products.vehicle');
    }
}
