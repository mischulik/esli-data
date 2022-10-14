<?php

namespace App\Http\Livewire\Products;

use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Stock extends Component
{
    public StockProduct $stockProduct;

    public function render(): Factory|View|Application
    {
        return view('products.stock');
    }
}
