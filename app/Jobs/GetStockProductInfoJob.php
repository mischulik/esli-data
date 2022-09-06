<?php

namespace App\Jobs;

use App\Actions\Data\StockProductInfoAction;
use App\Models\StockProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class GetStockProductInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private StockProduct $stockProduct;


    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->getStockProductId()))];
    }

    public function getStockProductId()
    {
        return $this->stockProduct->exists ?: $this->stockProduct->id;
    }

    public function getStockProduct(): StockProduct
    {
        return $this->stockProduct;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct->exists ? $stockProduct : $this->stockProduct;
        StockProductInfoAction::run($this->getStockProduct());
    }
}
