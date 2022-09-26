<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Item extends Component
{
    public Stock $stock;

    public function render()
    {
        return view('stocks.item')->with([
            'itemsCount' => $this->query()
                ->where(function (Builder $builder) {
                    $builder->whereHas('product', function (Builder $builder) {
                        return $builder->whereHas('actual_price');
                    })->present();
                })->count(),
        ]);
    }

    public function query(): Builder
    {
        return $this->stock->stock_products()->getQuery();
    }
}
