<?php

namespace App\Http\Livewire\Products;

use App\Http\Traits\WithCodeSearch;
use App\Http\Traits\WithGlassAccessoryFilter;
use App\Http\Traits\WithPlacement;
use App\Models\Product;
use Bastinald\Ui\Traits\WithModel;
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
    use WithModel;

    protected $listeners = [
        '$refresh',
        '$search' => 'somethingGoesOn',
    ];

    public function query(): Builder
    {
        return $this->queryCodeSearch(
            $this->queryGaFilter(
                $this->queryPlacement(
                    Product::with([
                        'manufacturer',
                        'vehicle',
                        'stock_products',
                        'stock_products.actual_quantity',
                    ])
//                        ->join('product_prices', 'product_prices.product_id', '=', 'products.id')->orderByDesc('product_prices.price')
//                        ->orderByDesc(ProductPrice::query()->select('price')->whereColumn('product_prices.product_id', 'products.id')->latest()->take(1))
                    ->orderByDesc('actual_price_date')
                )
            ));
    }


    public function somethingGoesOn(array $search)
    {
        foreach ($search as $key => $value)
        {
            $this->setModel($key, $value);
        }

        $this->emitSelf('$refresh');
    }

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/products', static::class)
            ->name('products')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('products.index', [
            'products' => $this->query()->paginate(),
        ]);
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
