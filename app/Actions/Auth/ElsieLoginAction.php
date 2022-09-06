<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Actions\CookieAction;
use Lorisleiva\Actions\Concerns\AsCommand;

class ElsieLoginAction extends CookieAction
{
    use AsAction;
    use AsCommand;

    public string $commandSignature = 'elsie:login {userId}';

    protected string $url = 'http://elsie.ua/ukr/login.html';

    public function handle(): ?string
    {
        $response = Http::asMultipart()->withHeaders([
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Host' => 'elsie.ua',
            'Origin' => 'http://elsie.ua',
            'Pragma' => 'no-cache',
            'Referer' => 'http://elsie.ua/ukr/login.html',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
        ])->post($this->url, $this->credentials->only([
            'email', 'passwd',
        ]));

        return $this->getCookies($response);
    }

    public function asCommand(Command $command)
    {
        optional($command->argument('userId') ?? null, function (string $userId) {
            auth()->loginUsingId($userId);
            optional(User::with('elsie_credentials')->find($userId) ?? null, function (User $user) {
                $this->credentials = $user->elsie_credentials;
                $this->handle();
            });
        });
    }
}
