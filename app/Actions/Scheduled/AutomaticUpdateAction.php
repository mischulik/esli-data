<?php

namespace App\Actions\Scheduled;

use App\Actions\Data\ElsieSearchAction;
use App\Actions\ElsieSearchParse;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsCommand;

class AutomaticUpdateAction
{
    use AsAction;
    use AsCommand;

    public string $commandSignature = 'elsie:update';

    public array $types = [
        'A', 'B', 'L', 'R',
    ];

    public function handle()
    {
        optional($this->getNeededProduct() ?? null, function (Product $product) {
            optional($this->getSearchTerm($product) ?? null, function (string $code) use ($product) {
                collect($this->types)->shuffle()->each(function (string $type) use ($code, $product) {
                    $code = implode('', [
                        $code,
                        $type,
                    ]);

                    dump($code);
                    $found = ElsieSearchAction::make()->handle([
                        'code' => $code,
                        'descr' => '',
                    ]);
                    dump($found);

                    $found = collect($found)->map(function (array $item) use ($product) {
                        $item['vehicle_id'] = $product->vehicle_id;
                        return ElsieSearchParse::make()->handle($item);
                    })->filter(function ($f) {
                        return is_array($f);
                    });

                    $saved = StockProduct::query()->whereHas('product', function (Builder $builder) use ($code) {
                        $builder->where('elsie_code', 'like', $code.'%');
                    })->get();

                    $found = $found->map(function (array $item) {
                        $product = Product::query()->firstOrCreate(
                            collect($item)->only('elsie_code')->toArray(),
                            collect($item)->except([
                                'stock',
                                'price',
                                'quantity',
                            ])->toArray()
                        );
                        $stock = Stock::query()->find($item['stock']);

                        return optional(StockProduct::query()->firstOrCreate([
                                'stock_id' => $stock->id,
                                'product_id' => $product->id,
                            ]) ?? null, function (StockProduct $stockProduct) use ($item) {
                            $stockProduct->quantities()->create(collect($item)->only('quantity')->toArray());
                            $stockProduct->product->prices()->create(collect($item)->only('price')->toArray());
                            return $stockProduct;
                        });
                    })->filter(function ($p)  {
                        return !is_null($p);
                    });

                    $saved = $saved->map(function (StockProduct $savedStockProduct) use ($found) {
                        $foundStockProduct = optional($found->firstWhere('id', '=', $savedStockProduct->id) ?? null, function (StockProduct $fsp) {
                            return $fsp;
                        });
                        return $foundStockProduct ? null : $savedStockProduct;
                    })->filter(function ($sp) {
                        return !is_null($sp);
                    })->each(function (StockProduct $stockProduct) {
                        $stockProduct->quantities()->create([
                            'quantity' => 0,
                        ]);
                    });
                });
            });
        });
    }

    public function asCommand(Command $command)
    {
        if (Http::get('http://elsie.ua')->status() != 502) {
            $this->handle();
        }
    }

    public function getNeededProduct(): Product
    {
        return optional(StockProduct::query()->orderBy('actual_quantity_date')->first() ?? null, function (StockProduct $stockProduct) {
            return $stockProduct->product;
        });
    }

    public function getSearchTerm(Product $product)
    {
        return optional(is_string($product->elsie_code) ? substr($product->elsie_code, 0, 4) : null, function (string $code) {
            return $code;
        });
    }
}
