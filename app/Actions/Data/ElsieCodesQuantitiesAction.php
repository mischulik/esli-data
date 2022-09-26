<?php

namespace App\Actions\Data;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;

class ElsieCodesQuantitiesAction
{
    use AsAction;
    use AsJob;

    //Using for an array of trash_codes
    public function handle(array $codes): Collection
    {
        ElsieTrashAction::run($codes, true);
        $trash = ElsieShowTrashAction::run($codes);
        ElsieRemoveFromTrashAction::run($codes);
//        ElsieTrashAction::run($codes);

        return $this->parseTrash($trash, $codes);
    }

    public function asJob($codes)
    {
        $this->handle($codes);
    }

    protected function parseTrashItem(array $item): array
    {
        $trashItem = [
            'stock' => $item[7] ?? null,
            'elsie_code' => $item[0] ?? null,
            'stock_code' => $item[1] ?? null,
        ];

        $stock = optional($item[7] ?? null, function (string $stock) {
            return !empty(trim($stock)) ? trim($stock) : null;
        });

        $product = optional($item[0] ?? null, function (string $product) {
            return !empty(trim($product)) ? trim($product) : null;
        });

        if (is_string($stock) && is_string($product)) {
            $trashItem['trash_code'] = implode('_', [
                $product, $stock,
            ]);
        }

        $width = optional($item[8] ?? null, function (string $width) {
            return !empty(trim($width)) ? trim($width) : null;
        });
        $height = optional($item[9] ?? null, function (string $height) {
            return !empty(trim($height)) ? trim($height) : null;
        });

        if (is_string($width) && is_string($height)) {
            $trashItem['size'] = implode('x', [
                $width, $height,
            ]);
        }

        $price = $item[3] ?? null;
        $trashItem['price'] = !empty(trim($price)) ? trim($price) : null;

        $quantity = $item[5] ?? null;
        $quantity = $quantity ?? ($item[6] ?? null);
        $trashItem['quantity'] = !empty(trim($quantity)) ? trim($quantity) : null;

        return $trashItem;
    }

    protected function parseTrash(array $trash = null, array $codes = null): Collection
    {
        $trash = $trash ?? [];
        $codes = $codes ?? [];

        return collect($trash)->map(function (array $item) use ($codes) {
            $item = $this->parseTrashItem($item);
            $trachCode = optional($item['trash_code'] ?? null, function (string $code) use ($codes) {
                return in_array($code, $codes) ? $code : null;
            });

            if ($product = Product::query()->whereElsieCode($item['elsie_code'])->first()) {
                if(is_string($item['price'])) {
                    $product->prices()->create([
                        'price' => $item['price'],
                    ]);
                }

                if ($stock = Stock::query()->whereShopId($item['stock'])->first()) {
                    if ($stockProduct = StockProduct::query()->firstOrCreate([
                        'stock_id' => $stock->id,
                        'product_id' => $product->id,
                    ])) {
                        if (is_string($item['quantity'])) {
                            $stockProduct->quantities()->create([
                                'quantity' => $item['quantity'],
                            ]);
                        }
                        return $stockProduct;
                    }
                }
                return null;
            }
            return null;
        })->filter(function ($item) {
            return is_a($item, StockProduct::class);
        });
    }
}
