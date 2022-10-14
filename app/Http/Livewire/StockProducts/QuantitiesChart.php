<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\StockProduct;
use App\Models\StockProductQuantity;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuantitiesChart extends Component
{
    public StockProduct $stockProduct;
    public string $title;

    protected $listeners = [
        '$refresh',
    ];

    public function render(): Factory|View|Application
    {
        return view('stock-products.quantities-chart')->with([
            'quantitiesChartModel' => $this->stockProduct->quantities()->get()
                ->reduce(function (LineChartModel $lineChartModel, StockProductQuantity $stockProductQuantity) {
                    return $lineChartModel->addPoint($stockProductQuantity->created_at->diffForHumans(), $stockProductQuantity->quantity);
                }, (new LineChartModel())
                    ->setTitle($this->title)
                    ->setAnimated(true)
                    ->withDataLabels()
                    ->withGrid()
                    ->setDataLabelsEnabled(true)
//                ->setColors('#aa0000')
                )
        ]);
    }
}
