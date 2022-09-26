<?php

namespace App\Http\Livewire\StockProducts;

use App\Actions\Data\StockProductInfoAction;
use App\Models\StockProduct;
use Livewire\Component;

class Header extends Component
{
    public StockProduct $stockProduct;

    public function render()
    {
        $this->stockProduct->refresh();
        return view('stock-products.header');
    }

    public function getInfo()
    {
        StockProductInfoAction::run($this->stockProduct);
    }
}
