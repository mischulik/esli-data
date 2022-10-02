<?php

namespace App\Http\Livewire\Products;

use App\Http\Traits\WithCodeSearch;
use App\Http\Traits\WithGlassAccessoryFilter;
use App\Http\Traits\WithPlacement;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithPlacement;
    use WithCodeSearch;
    use WithGlassAccessoryFilter;

    public string $search = '';

    protected $listeners = ['$refresh'];

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/products', static::class)
            ->name('products')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('products.index', [
            'products' =>
                $this->query()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        return $this->queryCodeSearch(
            $this->queryGaFilter(
                $this->queryPlacement(
                    Product::query()
//                        ->join('product_prices', 'product_prices.product_id', '=', 'products.id')->orderByDesc('product_prices.price')
                    ->orderByDesc(ProductPrice::query()->select('price')->whereColumn('product_prices.product_id', 'products.id')->latest()->take(1))
                )
            ))
//        )->orderByDesc(function ($builder) {
//            return $builder->orderBy('actual_price');
//        })
;
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
