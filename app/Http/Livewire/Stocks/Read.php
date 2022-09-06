<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Livewire\Component;

class Read extends Component
{
    public $stock;

    public function mount(Stock $stock = null)
    {
        $this->stock = $stock;
    }

    public function render()
    {
        return view('stocks.read');
    }
}
