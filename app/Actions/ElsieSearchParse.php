<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\StockProductPrice;
use App\Models\StockProductQuantity;
use App\Models\Vehicle;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieSearchParse
{
    use AsAction;

    protected array $keyMapping = [
        'elsie_code' => 0,
        'name' => 2,
        'price' => 3,
        'stock' => 5,
        'width' => 6,
        'height' => 7,
        'product_code' => 14,
        'quantity' => 16,
    ];

    public function handle(array $searchResult)
    {
        $parsed = collect(explode('-', collect(explode('.', $searchResult[0]))->first()))->last();
        $manufacturer = Product::suggestedManufacturer($parsed);

        $product = Product::firstOrCreate([
            'elsie_code' => $searchResult[0],
        ], [
            'name' => $searchResult[2],
            'vehicle_id' => $searchResult['vehicle_id'],
            'manufacturer_id' => $manufacturer?->id,
            'size' => implode('x', [
                $searchResult[6],
                $searchResult[7],
            ]),
        ]);


        if ($stock = Stock::firstWhere([
                'shop_id' => $searchResult[5],
            ])) {
            $stockProduct = StockProduct::firstOrCreate([
                'stock_id' => $stock->id,
                'product_id' => $product->id,
            ]);

            StockProductPrice::create([
                'stock_product_id' => $stockProduct->id,
                'price' => $searchResult[3],
            ]);

            StockProductQuantity::create([
                'stock_product_id' => $stockProduct->id,
                'quantity' => $searchResult[16],
            ]);
        }
    }
}
