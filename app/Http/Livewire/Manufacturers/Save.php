<?php

namespace App\Http\Livewire\Manufacturers;

use App\Models\Manufacturer;
use Bastinald\Ui\Traits\WithModel;
use Livewire\Component;

class Save extends Component
{
    use WithModel;

    public $manufacturer;

    public function mount(Manufacturer $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        $this->setModel($manufacturer->toArray());
    }

    public function render()
    {
        return view('manufacturers.save');
    }

    public function save()
    {
        $this->validateModel($this->manufacturer->rules());

        $this->manufacturer->fill($this->getModel())->save();

        $this->emit('hideModal');
        $this->emit('$refresh');
    }
}
