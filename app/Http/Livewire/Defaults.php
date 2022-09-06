<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Defaults extends Component
{
    public function route()
    {
        return Route::get('/defaults', static::class)
            ->name('defaults')->middleware('auth');
    }

    public function render()
    {
        return view('defaults');
    }
}
