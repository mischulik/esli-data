<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\StockProductQuantity;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class QuantitiesChart extends LineChart
{
    public function getChartModel()
    {
        return $this->query()
            ->get()->reduce(function (LineChartModel $lineChartModel, $stockProductQuantity) {
            return $lineChartModel->addPoint(
                Carbon::parse($stockProductQuantity->checked_at)->diffForHumans(),
                $stockProductQuantity->quantity
            );
        }, (new LineChartModel())->setTitle($this->title));
    }

    public function query()
    {
        return $this->stockProduct->quantities()->getQuery()
            ->select([
                DB::raw("(MAX(`quantity`)) as `quantity`"),
                DB::raw('(DATE_FORMAT(`created_at`, "%d-%m-%Y")) as `checked_at`'),
            ])
            ->orderBy('checked_at')
            ->groupBy('checked_at')
            ;
    }
}
