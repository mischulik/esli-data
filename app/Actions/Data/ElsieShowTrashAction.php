<?php

namespace App\Actions\Data;

use App\Actions\CookieAction;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;
use function optional;

class ElsieShowTrashAction extends CookieAction
{
    use AsAction;
    use AsJob;

    protected string $url = 'http://elsie.ua/ukr/shop/showtrash';

    public function handle(): ?array
    {
        $response = Http::asMultipart()->withHeaders([
                'Accept' => 'application/json, text/javascript, */*',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',

                'Cookie' => $this->credentials->header_value,
                'Host' => 'elsie.ua',
                'Origin' => 'http://elsie.ua',
                'Referer' => 'http://elsie.ua/ukr/shop/trash',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
                'X-Requested-With' => 'XMLHttpRequest',
            ])->post($this->url, []);

        $this->getCookies($response);

        return $response->json();
    }

    public function asJob()
    {
        return $this->handle();
    }
}
