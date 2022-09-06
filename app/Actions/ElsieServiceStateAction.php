<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieServiceStateAction
{
    use AsAction;

    protected string $url = 'http://elsie.ua';

    public function handle(): bool
    {
        return true;
//        return Http::withHeaders([
//            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
//            'Accept-Encoding: gzip, deflate',
//            'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
//            'Cache-Control: no-cache',
//            'Connection: keep-alive',
//            'Host: elsie.ua',
//            'Pragma: no-cache',
//            'Upgrade-Insecure-Requests: 1',
//            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36',
//        ])->get($this->url)->successful();
    }
}
