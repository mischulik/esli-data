<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
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
        return Route::get('/products1/{product}', static::class)
            ->name('products.show1')
            ->middleware(['auth', 'elsie_connection', 'elsie']);
    }

    public function render()
    {
        $this->product->fresh([
            'actual_price',
            'stock_products',
        ])->refresh();
        return view('products.show');
    }
}
