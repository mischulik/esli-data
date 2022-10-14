<?php

namespace App\Http\Livewire\StockProducts;

use App\Actions\Data\StockProductInfoAction;
use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Show extends Component
{
    public StockProduct $stockProduct;

    protected $listeners = [
        'neededProductUpdate' => '$refresh',
    ];

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/stock-products/{stockProduct}', static::class)
            ->name('stock-products.show')
            ->middleware([
                'auth',
//                'elsie_connection',
//                'elsie'
            ]);
    }

    public function render(): Factory|View|Application
    {
//        $this->getStockProductInfo();
//        $this->stockProduct->refresh();
        $this->emitTo('stock-products.quantities-chart', '$refresh');
        return view('stock-products.show');
    }

    public function getStockProductInfo()
    {
        StockProductInfoAction::run($this->stockProduct);
        $this->stockProduct->refresh();
        $this->emit('$refresh');
    }
}
