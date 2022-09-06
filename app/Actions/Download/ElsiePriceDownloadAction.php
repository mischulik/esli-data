<?php

namespace App\Actions\Download;

use Lorisleiva\Actions\Concerns\AsAction;
use function optional;
use function public_path;

class ElsiePriceDownloadAction
{
    use AsAction;

    protected string $url = 'http://elsie.ua/i/documents/Catalog_ELSIE.xls';

    protected function getFileName(): string
    {
        return public_path(implode('.', [
            implode('_', [
                pathinfo($this->url)['filename'],
                now()->timestamp,
            ]),
            pathinfo($this->url)['extension'],
        ]));
    }

    public function handle()
    {
        return optional($this->getFileName() ?? null, function (string $path) {
            $path = public_path('Catalog_ELSIE_1640824750.xls');
//            if (File::put($path, file_get_contents($this->url)) !== false) {
            return file_exists($path) ? $path : null;
//            }
//            return null;
        });
    }
}
