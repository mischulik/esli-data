<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\StockProduct;
use Livewire\Component;

class Item extends Component
{
    public Product $product;

    public function render()
    {
        return view('products.item')->with([
            'stockProducts' => StockProduct::with('actual_quantity')->select('*')->whereBelongsTo($this->product)->orderBy(\App\Models\Stock::query()->select('shop_id')->whereColumn('stocks.id', 'stock_products.stock_id'))->get(),
        ]);
    }
}
