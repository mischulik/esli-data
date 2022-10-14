<?php

namespace App\Http\Livewire\StockProducts;

use App\Actions\Data\StockProductInfoAction;
use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Item extends Component
{
    public StockProduct $stockProduct;

    protected $listeners = [
        '$getStockProductInfo' => 'getStockProductInfo',
    ];

    public function render(): Factory|View|Application
    {
//        dd($this->stockProduct->product->actual_price()->toSql());


//        $this->stockProduct->refresh();
        return view('stock-products.item')->with([
            'actual_price' => $this->stockProduct->product->actual_price,
            'actual_quantity' => $this->stockProduct->actual_quantity,
        ]);
    }

    public function getStockProductInfo()
    {
        StockProductInfoAction::run($this->stockProduct);
    }
}
