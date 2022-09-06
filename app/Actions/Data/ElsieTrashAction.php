<?php

namespace App\Actions\Data;

use App\Actions\CookieAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;

class ElsieTrashAction extends CookieAction
{
    use AsAction;

    protected string $url = 'http://elsie.ua/ukr/shop/trash.html';
    protected int $shop = 1;

    protected static int $MAX_COUNT = 1000000;

    //Using to add array of trash_codes to the trash
    public function handle(array $codes = [], bool $filled = false): string
    {
        return $this->getResponse($codes, $filled);
    }

    public function asJob(array $codes, bool $filled = false): string
    {
        return $this->handle($codes, $filled);
    }

    protected function getPostFields(array $codes, bool $filled): array
    {
        return collect($codes)->flip()->toArray();
    }

    protected function getResponse(array $codes, $filled): string
    {
        $data = $this->getPostFields($codes, $filled);
        foreach ($data as $key => $value) {
            $data[$key] = self::$MAX_COUNT;
        }

        $data = collect($data)->put('shop', $this->shop)->toArray();

//        dd($data);

        $response = Http::asForm()->withHeaders([
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Language' => 'ru-PL,ru;q=0.9,en-PL;q=0.8,en;q=0.7,uk-PL;q=0.6,uk;q=0.5,ru-RU;q=0.4,en-US;q=0.3,bn;q=0.2,pl;q=0.1',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie' => $this->credentials->header_value,
            'Origin' =>  'http://elsie.ua',
            'Pragma' => 'no-cache',
            'Referer' => 'http://elsie.ua/ukr/shop/items.html',
            'Upgrade-Insecure-Requests' => 1,
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36'
        ])->post($this->url, $data);

        $this->getCookies($response);
        return $response->body();
    }

    public function asCommand(Command $command)
    {

    }


    public function fdff()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://elsie.ua/ukr/shop/trash.html',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '4098AGNBLV-FU_18=1000&shop=1',
            CURLOPT_HTTPHEADER => array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Accept-Language: ru-PL,ru;q=0.9,en-PL;q=0.8,en;q=0.7,uk-PL;q=0.6,uk;q=0.5,ru-RU;q=0.4,en-US;q=0.3,bn;q=0.2,pl;q=0.1',
                'Cache-Control: no-cache',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: '.$this->credentials->header_value,

//                'Cookie: mojolicious=eyJuYW1lIjoiYXZ0b3N0ZWtsb3pwQGkudWEiLCJleHBpcmVzIjoxNjYzMDg1OTQ5fQ----878d2594e338970cbb0520c3d521cb93',
                //; mojolicious=eyJkZWxpdmVyeV9hZGRyZXNzIjoi0JfQsNC/0L7RgNC+0LbRjNC1LCDRg9C7LiDQmtGA0LjQstCw0Y8g0JHRg9GF0YLQsCwgMiwgKDA1MCkgMzQyLTg0LTg5IiwiY29tbWVudCI6IiIsImRlbGl2ZXJ5X2lzbmVlZGVkIjoiY2hlY2tlZD1cIjBcIiIsImRlbGl2ZXJ5X3Bob25lIjoiKDA2MSkgNzg3LTY1LTc2LCAoMDUwKSAzNDItODQtODkiLCJuYW1lIjoiYXZ0b3N0ZWtsb3pwQGkudWEiLCJleHBpcmVzIjoxNjYzMDkxNTgzfQ----25beb3702357853fab2b0c3bbea95b8a',
                'Origin: http://elsie.ua',
                'Pragma: no-cache',
                'Referer: http://elsie.ua/ukr/shop/items.html',
                'Upgrade-Insecure-Requests: 1',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
