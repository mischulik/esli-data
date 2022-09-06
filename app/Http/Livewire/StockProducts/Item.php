<?php

namespace App\Http\Livewire\StockProducts;

use App\Jobs\GetStockProductInfoJob;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\StockProductQuantity;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Item extends Component
{
    public StockProduct $stockProduct;
    public int $quantity = -1;

    protected $listeners = [
        '$getStockProductInfo' => 'getStockProductInfo',
    ];

    public function render()
    {
        return view('stock-products.item')->with([
            'stock' => optional($this->stockProduct->stock()->first() ?? null, function (Stock $stock) {
                return $stock;
            }),
            'product' => optional($this->stockProduct->product()->first() ?? null, function (Product $product) {
                return $product;
            }),
            'actual_price' => $this->stockProduct->actual_price,
        ]);
    }

    public function getStockProductInfo()
    {
        GetStockProductInfoJob::dispatch($this->stockProduct)->afterCommit();
        $actualQuantity = optional($this->stockProduct->getActualQuantityAttribute() ?? null, function (StockProductQuantity $stockProductQuantity) {
                return $stockProductQuantity;
            }) ?? new StockProductQuantity([
                'stock_product_id' => $this->stockProduct->id,
                'quantity' => 0,
            ]);
        $this->quantity = $actualQuantity->quantity;
    }
}
