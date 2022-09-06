<?php

namespace App\Actions\Data;

use App\Actions\CookieAction;
use App\Models\ElsieCredentials;
use Illuminate\Support\Facades\Http;
use function optional;

class ElsieSearchAction extends CookieAction
{
    protected string $url = 'http://elsie.ua/rus/shop/searchitem';

    public function handle(string $search): ?array
    {
        $this->setCredentials();

        return optional($this->credentials ?? null, function (ElsieCredentials $credentials) use ($search) {
            return Http::
            withBody($this->getBody($search), '')
                ->withHeaders([
                    'Accept' => 'application/json, text/javascript, */*',
                    'Accept-Encoding' => 'gzip, deflate',
                    'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
                    'Cache-Control' => 'no-cache',
                    'Connection' => 'keep-alive',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Cookie' => $credentials->header_value,
                    'Host' => 'elsie.ua',
                    'Origin' => 'http://elsie.ua',
                    'Pragma' => 'no-cache',
                    'Referer' => 'http://elsie.ua/rus/shop/items',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
                    'X-Requested-With' => 'XMLHttpRequest',
                ])
                ->post($this->url)
                ->json();
        });
    }

    protected function getBody(string $search): string
    {
        return implode('&', [
            implode('=', [
                'code',
                $search,
            ]),
            implode('=', [
                'descr', '',
            ])
        ]);
    }
}
