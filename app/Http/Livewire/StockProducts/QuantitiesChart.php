<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\StockProductQuantity;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class QuantitiesChart extends LineChart
{
    public function getChartModel()
    {
        return $this->stockProduct->quantities()->get()->reduce(function (LineChartModel $lineChartModel, StockProductQuantity $stockProductQuantity) {
            return $lineChartModel->addPoint($stockProductQuantity->created_at->diffForHumans(), $stockProductQuantity->quantity);
        }, (new LineChartModel())->setTitle($this->title));
    }
}
