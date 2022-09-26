<?php

namespace App\Actions\Data;

use App\Models\StockProduct;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;

class StockProductInfoAction
{
    use AsAction;
    use AsJob;

    //Using for One StockProduct object
    public function handle(StockProduct $stockProduct)
    {
        return optional($stockProduct->trash_code ?? null, function (string $trachCode) {
            return ElsieCodesQuantitiesAction::run([$trachCode]);
        });
    }

    public function asJob(StockProduct $stockProduct)
    {
        return $this->handle($stockProduct);
    }
}
