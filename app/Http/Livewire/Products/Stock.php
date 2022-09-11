<?php

namespace App\Http\Livewire\Products;

use App\Models\StockProduct;
use Livewire\Component;

class Stock extends Component
{
    public StockProduct $stockProduct;

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    public function render()
    {
        return view('products.stock')->with([
            'stock' => $this->stockProduct->stock,
            'actualQuantity' => $this->stockProduct->quantities()->latest()->first(),
        ]);
    }
}
