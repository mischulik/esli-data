<?php

namespace App\Http\Livewire\Products;

use App\Jobs\GetStockProductInfoJob;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\StockProductPrice;
use App\Models\StockProductQuantity;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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

    public function mount(Product $product)
    {
        $this->product = $product->exists ? $product : null;

        foreach (Stock::all() as $stock) {
            $stockProduct = StockProduct::query()->firstOrNew([
                'stock_id' => $stock->id,
                'product_id' => $product->id,
            ]);
            $stockProduct->save();
            GetStockProductInfoJob::dispatchSync($stockProduct);
        }
    }

    public function route()
    {
        return Route::get('/products/{product}', static::class)
            ->name('products.show')
            ->middleware(['auth', 'elsie_connection', 'elsie']);
    }

    public function render()
    {
        return view('products.show')->with([
            'stockProducts' => $this->product->stock_products()->whereHas('quantities')->get()->sortByDesc(function (StockProduct $stockProduct) {
                return $stockProduct->actual_quantity->quantity;
            }),
            'zeroProducts' => $this->product->stock_products()->whereDoesntHave('quantities')->get()->toBase(),

            'actual_price' => optional($this->product->stock_products()->whereHas('prices')->latest()->first() ?? null, function (StockProduct $product) {
                return optional($product->prices()->latest()->first() ?? null, function (StockProductPrice $price) {
                    return implode(' ', [$price->price, $price->currency]);
                });
            }),
        ]);
    }

    public function query()
    {

    }
}
