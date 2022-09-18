<?php

namespace App\Http\Livewire\StockProducts;

use App\Actions\Data\StockProductInfoAction;
use App\Models\StockProduct;
use Livewire\Component;

class Header extends Component
{
    public StockProduct $stockProduct;

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    public function render()
    {
        return view('stock-products.header');
    }

    public function getInfo()
    {
        StockProductInfoAction::run($this->stockProduct);
        $this->stockProduct->refresh();
    }
}
