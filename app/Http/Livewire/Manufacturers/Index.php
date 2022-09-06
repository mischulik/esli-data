<?php

namespace App\Http\Livewire\Manufacturers;

use App\Models\Manufacturer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public string $search = '';

    protected $listeners = ['$refresh'];

    public function route()
    {
        return Route::get('/manufacturers', static::class)
            ->name('manufacturers')
            ->middleware('auth');
    }

    public function render()
    {
        return view('manufacturers.index')->with([
            'manufacturers' => $this->query()->get(),
        ]);
    }

    public function query(): Builder
    {
        $query = Manufacturer::query()->withCount([
            'glasses', 'accessories'
        ])
            ->when($this->search, function (Builder $query) {
                return $query->where(function (Builder $query) {
                    $query->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code_suffix', 'like', $this->search . '%');
                });
            })->orderByDesc('glasses_count')->orderByDesc('accessories_count')
        ;

        return $query->orderBy('name');
    }

    public function delete(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
    }
}
