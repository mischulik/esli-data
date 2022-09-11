<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\StockProduct;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Livewire\Component;

class QuantitiesChart extends Component
{
    public StockProduct $stockProduct;

    protected $listeners = [
        '$refresh' => 'refresh',
    ];

    public function refresh()
    {
        $this->stockProduct->refresh();
    }

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    public function render()
    {
        $quantities = $this->stockProduct->quantities()->get();

        return view('stock-products.quantities-chart')->with([
            'lineChartModel' => $quantities->reduce(function (LineChartModel $lineChartModel, $data) use ($quantities) {
                return $lineChartModel->addPoint($data->created_at->diffForHumans(), $data->quantity)->setAnimated(true)->addColor('#90cdf4');
            }, new LineChartModel()),
        ]);
    }
}
