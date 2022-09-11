<?php

namespace App\Actions;

use App\Models\ElsieCredentials;
use App\Models\User;
use GuzzleHttp\Cookie\SetCookie;
use Lorisleiva\Actions\Concerns\AsAction;

class CookieAction
{
    use AsAction;

    protected ElsieCredentials $credentials;

    public function __construct()
    {
        $this->credentials = optional(auth()->user() ?? null, function (User $user) {
            return $user->elsie_credentials;
        }) ?? new ElsieCredentials();
    }

    public function getCookies($response): void
    {
        optional($response->cookies()->getCookieByName('mojolicious') ?? null, function (SetCookie $cookie) {
            $this->credentials->cookie = $cookie->getValue();
            $this->credentials->save();
        });
    }
}
