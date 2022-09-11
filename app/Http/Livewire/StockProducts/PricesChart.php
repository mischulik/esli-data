<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\StockProduct;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Livewire\Component;

class PricesChart extends Component
{
    public StockProduct $stockProduct;

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    protected $listeners = [
        '$refresh' => 'refresh',
    ];

    public function refresh()
    {
        $this->stockProduct->refresh();
    }

    public function render()
    {
        $prices = $this->stockProduct->prices()->get();
        return view('stock-products.prices-chart')->with([
            'lineChartModel' => $prices->reduce(function (LineChartModel $lineChartModel, $data) use ($prices) {
//                $index = $prices->search($data);
                return $lineChartModel->addPoint($data->created_at->diffForHumans(), $data->price);
            }, new LineChartModel()),
        ]);
    }
}
