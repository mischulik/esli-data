<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $sort = 'Name';
    public array $sorts = ['Name', 'Newest', 'Oldest'];
    public string $filter = 'All';
    public array $filters = ['All', 'Custom'];

    protected $listeners = ['$refresh'];

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
        $query = Stock::query()->withCount('products')->when($this->search, function (Builder $query) {
            return $query->orWhere('name', 'like', '%' . $this->search . '%');
        })->whereNotNull('shop_id');

        $query = $query->when($query->count() === 0, function (Builder $builder) {
            return $builder->whereHas('products', function (Builder $builder) {
                return $builder->where('elsie_code', 'like', $this->search . '%');
            });
        });
        return $query->orderByDesc('products_count');
    }

    public function delete(Stock $stock)
    {
        $stock->delete();
    }
}
