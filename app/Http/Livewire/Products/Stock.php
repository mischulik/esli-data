<?php

namespace App\Http\Livewire\Products;

use App\Models\StockProduct;
use Livewire\Component;

class Stock extends Component
{
    public StockProduct $stockProduct;

    public function render()
    {
        return view('products.stock');
    }
}
