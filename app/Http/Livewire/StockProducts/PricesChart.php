<?php

namespace App\Http\Livewire\StockProducts;


use App\Models\StockProductPrice;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class PricesChart extends LineChart
{
    public function getChartModel()
    {
        return $this->stockProduct->prices()->get()->reduce(function (LineChartModel $lineChartModel, StockProductPrice $stockProductPrice ) {
            return $lineChartModel->addPoint($stockProductPrice->created_at->diffForHumans(), $stockProductPrice->price);
        }, (new LineChartModel())->setTitle($this->title));
    }
}
