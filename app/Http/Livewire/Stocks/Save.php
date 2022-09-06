<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Bastinald\Ui\Traits\WithModel;
use Livewire\Component;

class Save extends Component
{
    use WithModel;

    public $stock;

    public function mount(Stock $stock = null)
    {
        $this->stock = $stock;

        $this->setModel($stock->toArray());
    }

    public function render()
    {
        return view('stocks.save');
    }

    public function save()
    {
        $this->validateModel($this->stock->rules());

        $this->stock->fill($this->getModel())->save();

        $this->emit('hideModal');
        $this->emit('$refresh');
    }
}
