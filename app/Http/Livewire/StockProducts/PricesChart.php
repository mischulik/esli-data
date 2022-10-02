<?php

namespace App\Http\Livewire\StockProducts;


use App\Models\Product;
use App\Models\ProductPrice;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class PricesChart extends LineChart
{
    public Product $product;

    public string $title = '123';

    public function getChartModel(): LineChartModel
    {
        return $this->product->prices()->get()->reduce(function (LineChartModel $lineChartModel, ProductPrice $productPrice ) {
            return $lineChartModel->addPoint($productPrice->created_at->diffForHumans(), $productPrice->price);
        }, (new LineChartModel())->setTitle($this->title));
    }
}
