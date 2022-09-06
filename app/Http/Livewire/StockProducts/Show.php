<?php

namespace App\Http\Livewire\StockProducts;

use App\Actions\Data\StockProductInfoAction;
use App\Jobs\GetStockProductInfoJob;
use App\Models\StockProduct;
use App\Models\StockProductPrice;
use App\Models\StockProductQuantity;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Show extends Component
{
    public StockProduct $stockProduct;

    protected $listeners = [
        'onQuantitiesPointClick' => 'handleQuantityOnPointClick',
        'onPricesPointClick' => 'handlePriceOnPointClick',
    ];

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct->exists ? $stockProduct : null;
    }

    public function route()
    {
        return Route::get('/stock-products/{stockProduct}', static::class)
            ->name('stock-products.show')
            ->middleware(['auth', 'elsie_connection', 'elsie']);
    }

    public function handlePriceOnPointClick($point)
    {
        dd($point);
    }

    public function handleQuantityOnPointClick($point)
    {
        dd($point);
    }

    public function render()
    {
        $this->getStockProductInfo();

        return view('stock-products.show')->with([
            'pricesChartModel' => optional(
                    $this->stockProduct->has('prices')
                        ? $this->stockProduct->prices()
                        ->oldest()
                        ->get()->groupBy(function ($item) {
                            return $item->created_at->format('Y-m-d');
                        })->map(function ($chunk) {
                            return $chunk->last();
                        })
                        ->reduce(function ($chartModel, StockProductPrice $price) {
                            return $chartModel->addPoint(
                                $price->created_at->longRelativeToNowDiffForHumans(),
                                $price->price, ['id' => $price->id]
                            );
                        },
                            LivewireCharts::areaChartModel()
                                ->setAnimated(true)
                                ->setSmoothCurve()
                                ->setLegendVisibility(true)
                                ->addPoint('', optional($this->stockProduct->prices()->first() ?? null, function (StockProductPrice $price) {
                                        return $price->price;
                                    }) ?? 0)
                        )
                        : null, function (AreaChartModel $chartModel) {
                    return $chartModel->setColor('green')->addPoint(
                        '',
                        optional($this->stockProduct->actual_price ?? null, function (StockProductPrice $price) {
                            return $price->price;
                        }) ?? 0
                    );
                }) ?? null,
            'quantityChartModel' =>
                optional(
                    $this->stockProduct->has('quantities')
                        ? $this->stockProduct->quantities()
                        ->oldest()
                        ->get()->groupBy(function ($item) {
                            return $item->created_at->format('Y-m-d');
                        })->map(function ($chunk) {
                            return $chunk->last();
                        })
                        ->reduce(
                            function ($chartModel, StockProductQuantity $quantity) {
                                return $chartModel->addPoint(
                                    $quantity->created_at->longRelativeToNowDiffForHumans(),
                                    $quantity->quantity,
                                    ['id' => $quantity->id]
                                );
                            },
                            LivewireCharts::areaChartModel()
                                ->setAnimated(true)
                                ->setSmoothCurve()
                                ->setLegendVisibility(true)
                                ->addPoint('',
                                    optional($this->stockProduct->quantities()->first() ?? null, function (StockProductQuantity $quantity) {
                                        return $quantity->quantity;
                                    }) ?? 0))
                        : null, function ($chartModel) {
                    return $chartModel->setColor('blue')->addPoint(
                        '',
                        optional($this->stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
                            return $quantity->quantity;
                        }) ?? 0);
                }) ??
                null,
        ]);
    }

    public function getStockProductInfo()
    {
        GetStockProductInfoJob::dispatchSync($this->stockProduct);
        $this->emit('$refresh');
    }
}
