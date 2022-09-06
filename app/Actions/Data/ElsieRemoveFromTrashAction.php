<?php

namespace App\Actions\Data;

use App\Actions\CookieAction;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieRemoveFromTrashAction extends CookieAction
{
    use AsAction;

    protected string $url = 'http://elsie.ua/ukr/shop/showtrash';


    public function handle(array $codes)
    {
        $data = [];
        foreach ($codes as $code) {
            $data[$code] = 0;
        }

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
        ])->post($this->url, $data);
    }
}
