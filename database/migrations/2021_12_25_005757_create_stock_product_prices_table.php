<?php

use App\Models\Price;
use App\Models\StockProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StockProduct::class, 'stock_product_id')->constrained('stock_products')->cascadeOnDelete();
            $table->unsignedBigInteger('price')->default(0)->index();
            $table->string('currency')->default('UAH');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_product_prices');
    }
}
