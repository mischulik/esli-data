<?php

namespace App\Http\Livewire\Products;

use App\Jobs\GetStockProductInfoJob;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Item extends Component
{
    public Product $product;

    public function render()
    {
        return view('products.item')->with([
            'price' => $this->product->actual_price,
            'quantity' => optional(Route::current()->parameter('stock') ?? null, function (Stock $stock) {
                return $this->quantityForStock($stock);
            }),
        ]);
    }

    public function quantityForStock(Stock $stock)
    {
        $sp = $this->product->stock_products()->firstWhere('stock_id', '=', $stock->id) ?? null;
        GetStockProductInfoJob::dispatchSync($sp);

        return optional($sp, function (StockProduct  $stockProduct) {
            return $stockProduct->actual_quantity;
        });
    }
}
