<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\StockProduct;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class FullShow extends Component
{
    public Product $product;

    public function route()
    {
        return Route::get('/products/{product}', static::class)
            ->name('products.show');
    }

    public function render()
    {
        $this->product->load('stock_products');

        return view('products.full-show')->with([
            'qChartModels' => $this->product->stock_products()->get()->map(function (StockProduct $stockProduct) {
                return $stockProduct->quantities()->get()->reduce(function (LineChartModel $lineChartModel, $stockProductQuantity) {
                    return $lineChartModel->addPoint(
                        Carbon::parse($stockProductQuantity->checked_at)->diffForHumans(),
                        $stockProductQuantity->quantity
                    );
                }, (new LineChartModel()));
            })->toArray(),
        ]);
    }
}
