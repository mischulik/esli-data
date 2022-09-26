<?php

namespace App\Http\Livewire\Products;

use App\Http\Traits\WithCodeSearch;
use App\Http\Traits\WithGlassAccessoryFilter;
use App\Http\Traits\WithPlacement;
use App\Models\Product;
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

    public function route()
    {
        return Route::get('/products', static::class)
            ->name('products')
            ->middleware('auth');
    }

    public function render()
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
                )
            )
        );
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
