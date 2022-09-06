<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Stock extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'stocks';

    protected $fillable = [
        'name',
        'shop_id',
    ];

    protected $withCount = [
        'products',
    ];

    public function stock_products(): HasMany
    {
        return $this->hasMany(StockProduct::class, 'stock_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, StockProduct::class, 'stock_id', 'product_id', 'id', 'id');
    }
}
