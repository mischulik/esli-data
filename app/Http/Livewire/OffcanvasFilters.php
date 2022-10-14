<?php

namespace App\Http\Livewire;

use App\Http\Traits\WithCodeSearch;
use App\Http\Traits\WithGlassAccessoryFilter;
use App\Http\Traits\WithPlacement;
use App\Models\Product;
use App\Models\ProductPrice;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class OffcanvasFilters extends Component
{
    use WithModel;
    use WithGlassAccessoryFilter;
    use WithCodeSearch;
    use WithPlacement;
    use WithPagination;

    public function render()
    {
        return view('offcanvas-filters')->with([

        ]);
    }

//    public function query(): Builder
//    {
//        return $this->queryCodeSearch(
//            $this->queryGaFilter(
//                $this->queryPlacement(
//                    Product::with([
//                        'manufacturer',
//                        'vehicle',
//                        'stock_products',
//                        'stock_products.actual_quantity',
//                        'actual_price'
//                    ])
////                        ->join('product_prices', 'product_prices.product_id', '=', 'products.id')->orderByDesc('product_prices.price')
//                        ->orderByDesc(ProductPrice::query()->select('price')->whereColumn('product_prices.product_id', 'products.id')->latest()->take(1))
//
//                )
//            ))
////        )->orderByDesc(function ($builder) {
////            return $builder->orderBy('actual_price');
////        })
//            ;
//    }

}
