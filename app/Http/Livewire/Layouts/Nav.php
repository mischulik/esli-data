<?php

namespace App\Http\Livewire\Layouts;

use App\Actions\ElsieServiceStateAction;
use App\Models\ElsieCredentials;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Redirector;

class Nav extends Component
{
    protected $listeners = ['$refresh'];

    public array $menuitems = [
        'users',
        'stocks',
        'manufacturers',
        'vehicles',
        'products',
    ];

    public function render()
    {
        return view('layouts.nav')->with([
            'isLoggedIn' => optional(auth()->user() ?? null, function (User $user) {
               return optional($user->elsie_credentials()->latest()->first() ?? null, function (ElsieCredentials $elsieCredentials) {
                   return $elsieCredentials->cookie;
               });
            }),
        ]);
    }

    public function logout(): Redirector
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
