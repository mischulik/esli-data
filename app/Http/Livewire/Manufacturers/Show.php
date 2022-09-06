<?php

namespace App\Http\Livewire\Manufacturers;

use App\Http\Traits\WithCodeSearch;
use App\Http\Traits\WithGlassAccessoryFilter;
use App\Http\Traits\WithPlacement;
use App\Models\Manufacturer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    use WithPlacement;
    use WithGlassAccessoryFilter;
    use WithCodeSearch;

    protected $listeners = ['$refresh'];

    public Manufacturer $manufacturer;

    public function route(): \Illuminate\Routing\Route
    {
        return Route::get('/manufacturers/{manufacturer}', static::class)
            ->name('manufacturers.show')
            ->middleware('auth');
    }

    public function render()
    {
        return view('manufacturers.show')->with([
            'products' => $this->query()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        return $this->queryCodeSearch(
            $this->queryPlacement(
                $this->queryGaFilter(
                    $this->manufacturer->products()->getQuery()
                )
            )
        );
    }
}
