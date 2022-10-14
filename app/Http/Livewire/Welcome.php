<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\StockProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Welcome extends Component
{
    public array $search;

    public function mount()
    {
        $this->search = empty($this->search) ? [
            'code' => '',
            'descr' => '',
        ] : $this->search;
    }

    public function route()
    {
        return Route::get('/', static::class)->name('welcome');
    }

    public function render()
    {
        dd(
            Product::query()->whereHas('stock_products', function (Builder $builder) {
                $builder->whereHas('quantities', function (Builder $builder) {
                    $builder->where('created_at', '>', today()->startOfDay());
                });
            })->orderByDesc('actual_price_date')->count()
        );

        return view('welcome');
    }

    public function searchUpdated()
    {
        dd($this->search);
    }
}
