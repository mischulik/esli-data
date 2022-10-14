<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\ProductPrice;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PricesChart extends Component
{
    public Product $product;
    public string $title;

    public $needsToShow = 0;

    protected $listeners = [
        'productDataUpdated' => 'actualPriceReceived',
    ];

    public function actualPriceReceived()
    {
        $this->product->load('actual_price');
        $this->needsToShow++;
    }

    public function updated()
    {
        $this->emitSelf('$refresh');
    }


    public function getDataModel()
    {
        return $this->needsToShow ? $this->product->prices()->get()
            ->reduce(function (LineChartModel $lineChartModel, ProductPrice $productPrice) {
                return $lineChartModel->addPoint($productPrice->created_at->diffForHumans(), $productPrice->price);
            }, (new LineChartModel())
                ->setTitle($this->title)
                ->setAnimated(true)
                ->withDataLabels()
                ->withGrid()
                ->setDataLabelsEnabled(true)
//                ->setColors('#aa0000')
            ) : null;
    }

    public function render(): Factory|View|Application
    {
        return view('products.prices-chart')->with([
            'pricesChartModel' => $this->getDataModel(),
        ]);
    }
}
