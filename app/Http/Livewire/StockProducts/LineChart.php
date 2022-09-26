<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\StockProduct;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Livewire\Component;

class LineChart extends Component
{
    public StockProduct $stockProduct;
    public string $title;

    protected $listeners = [
        '$refresh' => 'refresh',
    ];

    public function render()
    {
        $this->stockProduct->refresh();
        return view('stock-products.line-chart')->with([
            'lineChartModel' => $this->getChartModel(),
        ]);
    }

    public function getChartModel()
    {
        return new LineChartModel();
    }
}
