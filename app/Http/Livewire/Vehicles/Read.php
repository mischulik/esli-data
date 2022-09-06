<?php

namespace App\Http\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Read extends Component
{
    public $vehicle;

    public function mount(Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;
    }

    public function render()
    {
        return view('vehicles.read');
    }
}
