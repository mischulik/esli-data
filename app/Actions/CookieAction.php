<?php

namespace App\Actions;

use App\Models\ElsieCredentials;
use App\Models\User;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;

class CookieAction
{
    use AsAction;

    protected ElsieCredentials $credentials;

    public function __construct(ElsieCredentials $elsieCredentials = null)
    {
        $this->setCredentials($elsieCredentials);
    }

    protected function setCredentials(ElsieCredentials $elsieCredentials = null): void
    {
        $this->credentials = optional($elsieCredentials ?? null, function (ElsieCredentials $elsieCredentials) {
            return !empty($elsieCredentials->cookie) ? $elsieCredentials : $this->getUserCredentials();
        }) ?? $this->getUserCredentials();
    }

    public function getUserCredentials(): ElsieCredentials
    {
        return optional(auth()->id() ?? 1, function (int $userId) {
            return optional(User::with('elsie_credentials')->find($userId) ?? null, function (User $user) {
                return optional($user->elsie_credentials ?? null, function (ElsieCredentials $credentials) {
                    if (empty($credentials->cookie)) {
                        Artisan::call('elsie:login', [
                            'userId' => $credentials->user_id,
                        ]);
                    }
                    return $credentials->refresh();
                });
            }) ?? new ElsieCredentials([
                'user_id' => $userId,
                'cookie' => '',
            ]);
        }) ?? new ElsieCredentials();
    }


    protected function getCookies($response)
    {
        return optional($response->cookies()->getCookieByName('mojolicious') ?? null, function (SetCookie $cookie) {
            return optional($cookie->getValue() ?? null, function (string $cookie) {
                $this->credentials->cookie = $cookie;
                return $this->credentials->save();
            });
        });
    }
}
