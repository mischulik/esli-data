<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieSaveFound
{
    use AsAction;

    public function handle(array $parsed)
    {
        optional(Product::query()->firstOrCreate(
            collect($parsed)->only('elsie_code')->toArray(),
            collect($parsed)->except([
                'stock',
                'price',
                'quantity',
            ])->toArray()
        ) ?? null, function (Product $product) use ($parsed) {

            $product->prices()->create(collect($parsed)->only('price')->toArray());

            optional(Stock::query()->find($parsed['stock']) ?? null, function (Stock $stock) use ($product, $parsed) {
                optional(StockProduct::query()->firstOrCreate([
                    'product_id' => $product->id,
                    'stock_id' => $stock->id,
                ]) ?? null, function (StockProduct $stockProduct) use ($parsed) {
                    $stockProduct->quantities()->create(collect($parsed)->only('quantity')->toArray());
                });
            });
        });
    }
}
