<?php

namespace App\Services;

use App\Models\ElsieCredentials;
use App\Models\User;

class ElsieService
{
    public ElsieCredentials $elsieCredentials;

    public function __construct(ElsieCredentials $elsieCredentials)
    {
        $this->elsieCredentials = $elsieCredentials;
    }

    public function handleLogin(User $user)
    {
//        $this->elsieCredentials = optional($user->elsie_credentials()->first();
    }
}
