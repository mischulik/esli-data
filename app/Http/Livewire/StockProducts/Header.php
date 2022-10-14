<?php

namespace App\Http\Livewire\StockProducts;

use App\Actions\Data\StockProductInfoAction;
use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Header extends Component
{
    public StockProduct $stockProduct;

    public function render(): Factory|View|Application
    {
        return view('stock-products.header');
    }

    public function getInfo()
    {
        StockProductInfoAction::run($this->stockProduct);
    }
}
