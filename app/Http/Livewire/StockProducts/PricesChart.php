<?php

namespace App\Http\Livewire\StockProducts;


use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PricesChart extends LineChart
{
    public function getChartModel()
    {
        return $this->query()->get()
            ->reduce(function (LineChartModel $lineChartModel, $stockProductPrice) {
                return $lineChartModel
                    ->addPoint(
                        Carbon::parse($stockProductPrice->checked_at)->toFormattedDayDateString(),
                        $stockProductPrice->price
                    );
            }, (new LineChartModel())->setTitle($this->title));
    }

    public function query()
    {
        return $this->stockProduct->prices()->getQuery()
            ->selectRaw('DISTINCT `price`, DATE_FORMAT(`created_at`, "%Y-%m-%d") as `checked_at`')
            ->orderBy('checked_at')
//            ->groupBy('checked_at')
            ;
    }
}
