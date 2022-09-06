<?php

namespace App\Http\Livewire\Auth;

use App\Actions\Auth\ElsieLoginAction;
use App\Models\ElsieCredentials;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    use WithModel;

    public function route()
    {
        return Route::get('/login', static::class)
            ->name('login')
            ->middleware('guest');
    }

    public function render()
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

        $throttleKey = Str::lower($this->getModel('email')) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('email', __('auth.throttle', [
                'seconds' => RateLimiter::availableIn($throttleKey),
            ]));

            return;
        }

        if (!Auth::attempt($this->getModel(['email', 'password']))) {
            RateLimiter::hit($throttleKey);
            $this->addError('email', __('auth.failed'));
            return;
        }


        optional(\auth()->user() ?? null, function (User  $user) {
            optional($user->elsie_credentials()->updateOrCreate([
                'email' => $this->model['email'],
                'passwd' => $this->model['password']
            ]) ?? null, function (ElsieCredentials  $credentials) {
                ElsieLoginAction::make()->handle($credentials);
            });
        });

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
