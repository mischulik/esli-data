<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Save extends Component
{
    use WithModel;

    public User $user;

    public function mount(User $user = null)
    {
        $this->user = $user;

        $this->setModel($user->toArray());
    }

    public function render()
    {
        return view('users.save');
    }

    public function save()
    {
        $this->validateModel([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)],
        ]);

        $this->user->fill($this->getModel(['name', 'email', 'password']))->save();

        $this->emit('hideModal');
        $this->emit('$refresh');
    }
}
