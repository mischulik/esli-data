<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Collection $selectedStocks;
    public string $search;

    public Stock $stock;

    public function mount(Stock $stock)
    {
        $this->stock = $stock;
        $this->selectedStocks = collect([
            $this->stock,
        ]);
        $this->search = '';
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function query(): Builder
    {
        return StockProduct::query()->when($this->selectedStocks->count() !== 0, function (Builder $builder) {
            return $builder->whereIn('stock_id', $this->selectedStocks->pluck('id')->toArray());
        })->when(strlen($this->search > 3), function (Builder $builder) {
            return $builder->whereHas('product', function (Builder $builder) {
                return $builder->where('elsie_code', 'like', $this->search . '%');
            });
        })->whereHas('prices', function (Builder $builder) {
            $builder->where('price', '<>', 0);
        })->whereHas('quantities', function (Builder $builder) {
            $builder->where('quantity', '<>', 0);
        });
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
            'sProducts' => $this->query()->paginate(),
        ]);
    }
}
