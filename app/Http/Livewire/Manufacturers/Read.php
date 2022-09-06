<?php

namespace App\Http\Livewire\Manufacturers;

use App\Models\Manufacturer;
use Livewire\Component;

class Read extends Component
{
    public $manufacturer;

    public function mount(Manufacturer $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;
    }

    public function render()
    {
        return view('manufacturers.read');
    }
}
