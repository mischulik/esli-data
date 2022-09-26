<?php

namespace App\Actions;

use App\Actions\Data\ElsieSearchAction;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\Vehicle;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieVehicleProductsPricesAction
{
    use AsAction;

    public Vehicle $vehicle;

    public function handle(Vehicle $vehicle): ?Collection
    {
        $this->vehicle = $vehicle;

        return optional($this->searchVehicleProducts($vehicle) ?? null, function (Collection $found) {
                return $this->checkIfNotFound($found) ? null : $this->applyPrices($found);
            }) ?? null;
    }

    public function searchVehicleProducts(Vehicle $vehicle): ?Collection
    {
        return optional($vehicle->code ?? null, function (string $code) {
            return optional(ElsieSearchAction::make()->handle($code) ?? null, function (array $found) {
                return collect($this->parseFoundProducts($found));
            });
        });
    }

    public function parseFoundProducts(array $found): array
    {
        return collect($found)->filter(function ($item) {
            return !empty($item);
        })->map(function (array $item) {
            return $this->parseFoundItem($item);
        })->toArray();
    }

    public function parseFoundItem(array $p): array
    {
        $p = collect($p)->map(function ($item) {
            if (is_string($item)) {
                return !empty(trim($item)) ? trim($item) : null;
            }
            if (is_int($item)) {
                return $item === 0 ? null : $item;
            }
            return $item;
        });

        return collect([
            'elsie_code' => optional($p[0] ?? null, function (string $code) {
                    return $code;
                }) ?? null,
            'stock_code' => optional($p[1] ?? null, function (string $code) {
                    $code = trim($code);
                    $code = !empty($code) ? $code : '.';
                    return str_contains('.', $code) ? null : $code;
                }) ?? null,
            'width' => $p[6] ?? null,
            'height' => $p[7] ?? null,
            'stock' => optional($p[5] ?? null, function ($shop_id) {
                return $shop_id;
            }),
            'price' => optional($p[3] ?? null, function ($price) {
                return $price;
            }),
            'search_name' => $p[2] ?? null,
            'note' => $p[8] ?? null,
        ])->toArray();
    }

    protected function checkIfNotFound(Collection $collection): bool
    {
        if ($collection->count() === 1) {
            if ($item = $collection->first()) {
                $item = is_array($item) ? collect($item)->values() : null;
                return $item && $item->first() === 'message';
            }
        }
        return false;
    }

    public function applyPrices(Collection $found): Collection
    {
        return $found->filter(function ($item) {
            return !empty($item);
        })->map(function (array $item) {
            return collect($item);
        })->map(function (Collection $pData) {
            return optional(Product::query()->firstWhere($pData->only([
                    'elsie_code', 'width', 'height',
                ])->toArray()) ?? null, function (Product $product) use ($pData) {

                if ($this->vehicle->products()->whereIn('id', [$product->id])->doesntExist()) {
                    $this->vehicle->products()->attach($product->id);
                }

                $product->update($pData->only([
                    'search_name', 'note',
                ])->toArray());

                $parsedCode = Product::parseCode($product->elsie_code);
                if (!$product->manufacturer_id) {
                    $manufacturer = optional($parsedCode['manufacturer_code'] ?? null, function (string $suffix) {
                        return Product::suggestedManufacturer($suffix);
                    });
                    if (is_a($manufacturer, Manufacturer::class)) {
                        $product->manufacturer_id = $manufacturer->id;
                    }
                }

                $name = optional($pData['search_name'] ?? null, function (string $searchName) use ($product) {
                    $vehicleFullName = optional($this->vehicle->full_name ?? null, function (string $fullName) {
                            return $fullName;
                        }) ?? null;
                    if (!empty($vehicleFullName)) {
                        $searchName = str_replace($vehicleFullName, '', $searchName);
                    }
                    $manufacturerName = optional($product->manufacturer()->first() ?? null, function (Manufacturer $manufacturer) {
                        return $manufacturer->name;
                    });
                    if (!empty($manufacturerName)) {
                        $searchName = str_replace($manufacturerName, '', $searchName);
                    }
                    return trim($searchName, ' ,');
                });

                if (is_string($name) && $name !== $product->name) {
                    $product->name = $name;
                }

                $product->save();

                optional($pData['price'] ?? null, function($price) use ($product) {
                    $product->prices()->create([
                        'price' => $price,
                    ]);
                });

                return optional($pData['stock'] ?? null, function ($shopId) use ($product, $pData) {
                    $stock = optional(Stock::query()->firstWhere('shop_id', '=', $shopId) ?? null, function (Stock $stock) {
                        return $stock;
                    });

                    return StockProduct::query()->firstOrCreate([
                            'stock_id' => $stock->id,
                            'product_id' => $product->id,
                        ]);
                });
            });
        })->filter(function ($item) {
            return is_a($item, StockProduct::class);
        })->map(function (StockProduct $product) {
            return $product->trash_code;
        });
    }
}
