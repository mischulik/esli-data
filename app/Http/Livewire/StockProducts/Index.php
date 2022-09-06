<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $code = '';
    public string $name = '';
    public string $vehicle = '';
    public int $manufacturerId = 0;
    public bool $showFilled = true;

    public Stock $stock;

    public function mount(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function query(): Builder
    {
        return $this->stock->stock_products()->with([
            'product',
            'product.vehicle',
            'product.manufacturer',
        ])->when($this->showFilled, function (Builder $builder) {
            return $builder->present();
        })
            ->when(!empty($this->code), function (Builder $builder) {
                return $builder->whereHas('product', function (Builder $builder) {
                    return $builder->where('elsie_code', 'like', $this->code . '%');
                });
            })
            ->when(!empty($this->name), function (Builder $builder) {
                return $builder->whereHas('product', function (Builder $builder) {
                    return $builder->where('name', 'like', '%' . $this->name . '%');
                });
            })
            ->when(!empty($this->vehicle), function (Builder $builder) {
                return $builder->whereHas('product', function (Builder $builder) {
                    return $builder->whereHas('vehicle', function (Builder $builder) {
                        return $builder->where('name', 'like', '%' . $this->vehicle . '%');
                    });
                });
            })
            ->when($this->manufacturerId, function (Builder $builder) {
                return $builder->whereHas('product', function (Builder $builder) {
                    return $builder->whereHas('manufacturer', function (Builder $builder) {
                        return $builder->where('id', '=', $this->manufacturerId);
                    });
                });
            })
            ->getQuery();
    }

    public function route()
    {
        return Route::get('/stock/{stock}/products', static::class)
            ->name('stock-products')
            ->middleware('auth');
    }

    public function render()
    {
        return view('stock-products.index')->with([
            'stockProducts' => $this->query()->paginate(),
        ]);
    }
}
