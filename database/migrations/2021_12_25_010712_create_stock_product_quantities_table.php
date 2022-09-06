<?php

use App\Models\StockProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockProductQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_product_quantities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StockProduct::class, 'stock_product_id')->constrained('stock_products')->cascadeOnDelete();
            $table->unsignedBigInteger('quantity')->default(0);
            $table->string('units')->default('pcs');
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
        Schema::dropIfExists('stock_product_quantities');
    }
}
