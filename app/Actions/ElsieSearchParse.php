<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Stock;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieSearchParse
{
    use AsAction;

    public function handle(array $searchResult)
    {
        if (!isset($searchResult[5])) {
            return null;
        }

        $parsed = collect(explode('-', collect(explode('.', $searchResult[0]))->first()))->last();
        $manufacturer = Product::suggestedManufacturer($parsed);
        $stock = Stock::query()->whereShopId($searchResult[5])->first();

        return [
            'elsie_code' => $searchResult[0] ? trim($searchResult[0]) : null,
            'name' => $searchResult[2] ? trim($searchResult[2]) : null,
            'vehicle_id' => $searchResult['vehicle_id'],
            'manufacturer_id' => $manufacturer?->id,
            'size' => $this->getSize($searchResult),
            'stock' => $stock?->id,
            'price' => $searchResult[3] ? intval($searchResult[3]) : null,
            'quantity' => $searchResult[16] ? intval($searchResult[16]) : null,
        ];

//        $product = Product::query()->firstOrCreate([
//            'elsie_code' => $searchResult[0],
//        ], [
//            'name' => $searchResult[2],
//            'vehicle_id' => $searchResult['vehicle_id'],
//            'manufacturer_id' => $manufacturer?->id,
//            'size' => implode('x', [
//                $searchResult[6],
//                $searchResult[7],
//            ]),
//        ]);


//        if ($stock) {
//            $stockProduct = StockProduct::query()->firstOrCreate([
//                'stock_id' => $stock->id,
//                'product_id' => $product->id,
//            ]);
//
//            $product->prices()->create([
//                'price' => $searchResult[3],
//            ]);
//
//            StockProductQuantity::query()->create([
//                'stock_product_id' => $stockProduct->id,
//                'quantity' => $searchResult[16],
//            ]);
//        }
    }

    public function getSize(array $searchResult)
    {
        $width = optional($searchResult[6] ? intval($searchResult[6]) : null, function (int $width) {
            return $width;
        });
        $height = optional($searchResult[7] ? intval($searchResult[7]) : null, function(int $height) {
            return $height;
        });

        return ($width && $height) ? implode('x', [
            $width,
            $height,
        ]) : null;
    }
}
