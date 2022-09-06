<?php

use App\Models\Manufacturer;
use App\Models\Vehicle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('elsie_code')->unique();
            $table->string('stock_code')->nullable();
            $table->foreignIdFor(Manufacturer::class, 'manufacturer_id')->nullable()->constrained('manufacturers')->cascadeOnDelete();
            $table->foreignIdFor(Vehicle::class, 'vehicle_id')->nullable()->constrained('vehicles')->cascadeOnDelete();

            $table->text('name')->nullable();
            $table->longText('search_name')->nullable();
            $table->string('note')->nullable();
            $table->string('size')->nullable();

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products');
        Schema::enableForeignKeyConstraints();
    }
}
