<?php

namespace App\Actions\Data;

use App\Actions\CookieAction;
use App\Models\ElsieCredentials;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsJob;

class ElsieSearchAction extends CookieAction
{
    use AsJob;

    protected string $url = 'http://elsie.ua/rus/shop/searchitem';

    public string $commandSignature = 'elsie:search {code} {descr?}';

    public function handle(array $search): ?array
    {
        if (auth()->id()) {
            $this->credentials = ElsieCredentials::query()->find(auth()->id());
        } else {
            $this->credentials = ElsieCredentials::find(1);
        }

        $response = Http::withBody($this->getBody($search), 'application/x-www-form-urlencoded')
            ->withHeaders([
                'Accept' => 'application/json, text/javascript, */*',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Cookie' => $this->credentials->header_value,
                'Host' => 'elsie.ua',
                'Origin' => 'http://elsie.ua',
                'Pragma' => 'no-cache',
                'Referer' => 'http://elsie.ua/rus/shop/items',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
                'X-Requested-With' => 'XMLHttpRequest',
            ])
            ->post($this->url);

        $this->getCookies($response);
        return $response->json();
    }

    public function asCommand(Command $command)
    {
        $this->handle($command->arguments());
    }

    protected function getBody(array $search): string
    {
        $body = [];
        foreach ($search as $key => $value) {
            $body[] = implode('=', [
                $key,
                urlencode($value),
            ]);
        }
        return implode('&', $body);
    }
}
