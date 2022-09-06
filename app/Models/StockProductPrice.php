<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockProductPrice extends Model
{
    use HasFactory;

    protected $table = 'stock_product_prices';

    protected $fillable = [
        'stock_product_id',
        'price',
        'currency',
    ];

    public function stock_product(): BelongsTo
    {
        return $this->belongsTo(StockProduct::class, 'stock_product_id', 'id');
    }
}
