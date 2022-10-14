<?php

namespace App\Http\Livewire\Products;

use App\Actions\Data\ElsieSearchAction;
use App\Actions\ElsieSaveFound;
use App\Actions\ElsieSearchParse;
use App\Models\Product;
use App\Models\StockProduct;
use App\Models\StockProductQuantity;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Header extends Component
{
    public Product $product;

    protected $listeners = [
        'getProductInfo',
    ];

    public function getProductInfo()
    {
        $data = ElsieSearchAction::run([
            'code' => substr($this->product->elsie_code, 0, 5),
        ]);
        $data = collect($data)->map(function ($d) {
            $d['vehicle_id'] = $this->product->vehicle_id;
            return ElsieSearchParse::run($d);
        })->each(function ($d) {
            ElsieSaveFound::run($d);
        });

        $this->emit('showToast', 'info', __('Информация обновлена'));
        $this->emitUp('neededProductUpdate', $this->product);
    }

    public function render(): Factory|View|Application
    {
        $this->product->refresh();
        return view('products.header')->with([
            'totalQuantity' => $this->product->stock_products()->get()->map(function (StockProduct $stockProduct) {
                return $stockProduct->actual_quantity;
            })->sum(function (StockProductQuantity $stockProductQuantity) {
                return $stockProductQuantity->quantity;
            }),
        ]);
    }
}
