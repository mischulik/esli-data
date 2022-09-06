<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Password extends Component
{
    use WithModel;

    public User $user;

    public function mount(User $user = null)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('users.password');
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed'],
        ];
    }

    public function save()
    {
        $this->validateModel();

        $this->user->update($this->getModel(['password']));

        $this->emit('hideModal');
    }
}
