<?php

namespace App\Actions;

use App\Actions\Auth\ElsieLoginAction;
use App\Models\ElsieCookie;
use App\Models\ElsieCredentials;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CookieAction
{
    use AsAction;

    protected ?ElsieCredentials $credentials;

    public function __construct(ElsieCredentials $credentials = null)
    {
        $this->credentials = $credentials;
    }

    protected function setCredentials()
    {
        $this->credentials = optional(auth()->user() ?? User::query()->find(1), function (User $user) {
            return optional($user->elsie_credentials()->first() ?? null, function (ElsieCredentials $credentials) {
                if (!$credentials->cookie) {
                    ElsieLoginAction::make()->handle($credentials);
                }
                return $credentials->refresh();
            });
        });
    }
}
