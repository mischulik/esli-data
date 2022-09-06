<?php

namespace App\Actions\Auth;

use App\Models\ElsieCookie;
use App\Models\ElsieCredentials;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;
use function optional;

class ElsieLoginAction
{
    use AsAction;

    protected string $url = 'http://elsie.ua/rus/login.html';

    public function handle(ElsieCredentials $credentials): ?string
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
            'Referer' => 'http://elsie.ua/rus/login.html',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
        ])->post($this->url, $credentials->only([
            'email', 'passwd',
        ]));

        optional($response->cookies()->getCookieByName('mojolicious') ?? null, function (SetCookie $cookie) use ($credentials) {
            $credentials->update([
                'cookie' => $cookie->getValue(),
            ]);
        });
        return $credentials->refresh()->getAttribute('cookie');
    }
}
