<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\StockProduct;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Product $product;

    protected $listeners = [
        '$refresh',
    ];

    public function route()
    {
        return Route::get('/products/{product}', static::class)
            ->name('products.show')
            ->middleware(['auth', 'elsie_connection', 'elsie']);
    }

    public function render()
    {
        return view('products.show');
    }
}
