<?php

namespace App\Http\Livewire\Vehicles;

use App\Models\Vehicle;
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

    public Vehicle $vehicle;

    public function route()
    {
        return Route::get('/vehicles/{vehicle}', static::class)
            ->name('vehicles.show')
            ->middleware('auth');
    }

    public function query(): Builder
    {
        return $this->vehicle->products()->getQuery();
    }

    public function render()
    {
        return view('vehicles.show')->with([
            'products' => $this->query()->paginate(),
        ]);
    }
}
