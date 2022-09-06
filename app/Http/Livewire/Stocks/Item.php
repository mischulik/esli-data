<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Item extends Component
{
    public Stock $stock;

    public function render()
    {
        return view('stocks.item')->with([
            'itemsCount' => $this->query()->whereHas('prices', function (Builder $builder) {
                return $builder->where('price', '>', 0);
            })->whereHas('quantities', function (Builder $builder) {
                return $builder->where('quantity', '>', 0);
            })->count(),
        ]);
    }

    public function query()
    {
        return $this->stock->stock_products()->getQuery();
    }
}
