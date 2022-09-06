<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Read extends Component
{
    public User $user;

    public function mount(User $user = null)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('users.read');
    }
}
