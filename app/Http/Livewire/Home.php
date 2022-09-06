<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Home extends Component
{
    public function route()
    {
        return Route::get('/home', static::class)
            ->middleware('auth')
            ->name('home');
    }

    public function render()
    {
        return view('home');
    }
}
