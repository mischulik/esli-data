<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    protected $listeners = ['$refresh'];
    public bool $showFilled = true;

    public function route(): \Illuminate\Routing\Route
    {
        return Route::get('/stocks', static::class)
            ->name('stocks')
            ->middleware('auth');
    }

    public function render()
    {
        return view('stocks.index', [
            'stocks' => $this->query()->get(),
        ]);
    }

    public function query(): Builder
    {
        return Stock::query()->when($this->showFilled, function (Builder $builder) {
            return $builder->filled();
        })->when(!empty($this->search), function (Builder $builder) {
            return $builder->where('name', 'like', '%' . $this->search . '%');
        });
    }

    public function delete(Stock $stock)
    {
        $stock->delete();
    }
}
