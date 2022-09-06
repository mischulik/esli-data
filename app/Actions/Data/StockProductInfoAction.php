<?php

namespace App\Actions\Data;

use App\Models\StockProduct;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;

class StockProductInfoAction
{
    use AsAction;
    use AsJob;

    public StockProduct $stockProduct;

    public function __construct(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    //Using for One StockProduct object
    public function handle(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct->exists ? $stockProduct : $this->stockProduct;

        return optional($stockProduct->getTrashCodeAttribute() ?? null, function (string $trachCode) {
            return ElsieCodesQuantitiesAction::run([$trachCode]);
        });
    }
    public function asJob(StockProduct $stockProduct)
    {
        return $this->handle($stockProduct);
    }
}
