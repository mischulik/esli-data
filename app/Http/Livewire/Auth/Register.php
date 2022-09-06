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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Redirector;
use Lukeraymonddowning\Honey\Traits\WithHoney;

class Register extends Component
{
    use WithHoney, WithModel;

    public function route()
    {
        return Route::get('/register', static::class)
            ->name('register')
            ->middleware('guest');
    }

    public function render()
    {
        return view('auth.register');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function register()
    {
        $this->validateModel();

        $redirect = optional(User::query()->create([
                    'email' => $this->getModel('email'),
                    'name' => $this->getModel('name'),
                    'password' => bcrypt($this->getModel('password'))
                ]) ?? null, function (User $user) {

                Auth::login($user, true);
                $user->elsie_credentials()->delete();
                optional($user->elsie_credentials()->create([
                        'email' => $this->getModel('email'),
                        'passwd' => $this->getModel('password'),
                    ]) ?? null, function (ElsieCredentials $credentials) {
                    ElsieLoginAction::make()->handle($credentials);
                });

                return RouteServiceProvider::HOME;
            }) ?? 'login';

        return redirect()->to($redirect);
    }
}
