<?php

namespace App\Actions\Data;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;

class ElsieCodesQuantitiesAction
{
    use AsAction;
    use AsJob;

    //Using for an array of trash_codes
    public function handle(array $codes)
    {
        ElsieTrashAction::run($codes, true);
        $trash = ElsieShowTrashAction::run($codes);
        ElsieRemoveFromTrashAction::run($codes);

        return $this->parseTrash($trash, $codes);
    }

    public function asJob($codes)
    {
        $this->handle($codes);
    }

    protected function parseTrashItem(array $item): array
    {
        $trashItem = [
            'stock' => isset($item[7]) ? intval($item[7]) : null,
            'elsie_code' => $item[0] ?? null,
            'stock_code' => $item[1] ?? null,
        ];

        $stock = optional($trashItem['stock'] ?? null, function (string $stock) {
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
        $trashItem['price'] = !empty(trim($price)) ? intval(trim($price)) : null;

        $quantity = isset($item[5]) ? intval(trim($item[5])) : null;
        $trashItem['quantity'] = $quantity ?? (isset($item[6]) ? intval(trim($item[6])) : null);

        return $trashItem;
    }

    protected function parseTrash(array $trash = null, array $codes = null)
    {
        $trash = $trash ?? [];
        $codes = $codes ?? [];

        return collect($trash)->map(function (array $item) use ($codes) {
            $item = $this->parseTrashItem($item);
            $trachCode = optional($item['trash_code'] ?? null, function (string $code) use ($codes) {
                return in_array($code, $codes) ? $code : null;
            });

            if ($product = Product::query()->whereElsieCode($item['elsie_code'])->first()) {
                if(isset($item['price'])) {
                    $price = $product->prices()->create([
                        'price' => intval($item['price']),
                    ]);
                }

                if ($stock = Stock::query()->whereShopId($item['stock'])->first()) {
                    if ($stockProduct = StockProduct::query()->firstOrCreate([
                        'stock_id' => $stock->id,
                        'product_id' => $product->id,
                    ])) {
                        if (isset($item['quantity'])) {
                            $quantity = $stockProduct->quantities()->create([
                                'quantity' => $item['quantity'],
                            ]);
                        }
                        return $stockProduct->load([
                            'quantities',
                            'actual_quantity',
                        ]);
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
