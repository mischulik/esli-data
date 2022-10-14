<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class FullShow extends Component
{
    public Product $product;

    protected $listeners = [
        'neededProductUpdate' => 'getProductInfo',
    ];

    public function getProductInfo(Product $product)
    {
        $this->product = $product;
        $this->emitTo('products.prices-chart', 'productDataUpdated', $this->product->id);
    }


    public function route(): \Illuminate\Routing\Route
    {
        return Route::get('/products/{product}', static::class)
            ->name('products.show');
    }

    public function render(): Factory|View|Application
    {
        return view('products.full-show');
    }
}
