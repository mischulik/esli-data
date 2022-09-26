<?php

namespace App\Http\Livewire\StockProducts;

use App\Actions\Data\StockProductInfoAction;
use App\Models\StockProduct;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Show extends Component
{
    public StockProduct $stockProduct;

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
        StockProductInfoAction::run($stockProduct);
    }

    public function route()
    {
        return Route::get('/stock-products/{stockProduct}', static::class)
            ->name('stock-products.show')
            ->middleware(['auth', 'elsie_connection', 'elsie']);
    }

    public function render()
    {
        $this->stockProduct->refresh();
        return view('stock-products.show')->with([]);
    }

    public function getStockProductInfo()
    {
        StockProductInfoAction::run($this->stockProduct);
        $this->emit('$refresh');
    }
}
