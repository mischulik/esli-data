<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\StockProduct;
use App\Models\StockProductPrice;
use Livewire\Component;

class Item extends Component
{
    public Product $product;

    public function render()
    {
        $stockProduct = optional($this->product->stock_products->first());

        return view('products.item')->with([
            'price' => optional($this->product->stock_products->first() ?? null, function (StockProduct $stockProduct) {
                    return $stockProduct->actualPrice;
                }) ?? new StockProductPrice([
                    'price' => 0,
                ]),
        ]);
    }
}
