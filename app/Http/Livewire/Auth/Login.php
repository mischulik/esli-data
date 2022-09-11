<?php

namespace App\Http\Livewire\Auth;

use App\Actions\Auth\ElsieLoginAction;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Login extends Component
{
    use WithModel;

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/login', static::class)
            ->name('login')
            ->middleware('guest');
    }

    public function render(): Factory|View|Application
    {
        return view('auth.login');
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function login()
    {
        $this->validateModel();

        $user = optional(User::whereHas('elsie_credentials', function (Builder $builder) {
            $builder->where([
                'email' => $this->model['email'],
                'passwd' => $this->model['password'],
            ]);
        })->first() ?? null, function (User $user) {
            auth()->login($user);
            return $user;
        });

        if ($user) {
            if (ElsieLoginAction::make()->handle()) {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }
        return back()->withErrors([
            'email' => 'Wrong',
        ]);
    }

}
