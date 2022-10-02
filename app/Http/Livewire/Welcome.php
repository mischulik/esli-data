<?php

namespace App\Http\Livewire;

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
        return view('welcome');
    }

    public function searchUpdated()
    {
        dd($this->search);
    }
}
