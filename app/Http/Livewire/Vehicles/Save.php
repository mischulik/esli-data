<?php

namespace App\Http\Livewire\Vehicles;

use App\Models\Vehicle;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Save extends Component
{
    use WithModel;

    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;
        $this->setModel($vehicle->toArray());
    }

    public function render()
    {
        return view('vehicles.save');
    }

    public function save()
    {
        $this->validateModel($this->vehicle->rules());

        $this->vehicle->fill($this->getModel())->save();

        $this->emit('hideModal');
        $this->emit('$refresh');
    }
}
