<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class Manufacturer extends Component
{
    public \App\Models\Manufacturer $manufacturer;

    public function mount(\App\Models\Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    public function render()
    {
        return view('products.manufacturer');
    }
}
