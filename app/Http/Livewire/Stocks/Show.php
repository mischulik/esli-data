<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Stock $stock;

    public function route()
    {
        return Route::get('/stocks/{stock}', static::class)
            ->name('stocks.show')
            ->middleware('auth');
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function render()
    {
        return view('stocks.show')->with([
            'stockProducts' => $this->query()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        return $this->stock->stock_products()->present()->getQuery();
    }
}
