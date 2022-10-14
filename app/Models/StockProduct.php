<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class StockProduct extends Model
{
    use HasFactory;

    protected $table = 'stock_products';

    protected $fillable = [
        'stock_id',
        'product_id',
    ];

    protected $withCount = [
        'quantities',
    ];

    protected $with = [
//        'actual_quantity',
//        'quantities',
    ];

    public function newQuery()
    {
        return parent::newQuery()->addSelect([
            'actual_quantity_quantity' => StockProductQuantity::query()
                ->select('quantity')
                ->whereColumn('stock_product_id', 'stock_products.id')
                ->latest()
                ->take(1),
            'actual_quantity_units' => StockProductQuantity::query()
                ->select('units')
                ->whereColumn('stock_product_id', 'stock_products.id')
                ->latest()
                ->take(1),
            'actual_quantity_date' => StockProductQuantity::query()
                ->select('created_at')
                ->whereColumn('stock_product_id', 'stock_products.id')
                ->latest()
                ->take(1),
        ]);
    }

    public function scopePresent(Builder $builder)
    {
        $builder->where(function (Builder $builder) {
            $builder->whereHas('quantities', function (Builder $builder) {
                return $builder->where('quantity', '>', 0)->whereNotNull('quantity');
            });
        });
    }

    public static function findByTrashCode(string $trashCode): ?StockProduct
    {
        $trashCode = collect(explode('_', $trashCode));
        if ($trashCode->count() === 2) {
            $product = optional($trashCode->first() ?? null, function (string $productCode) {
                return Product::query()->firstWhere([
                    'elsie_code' => $productCode,
                ]);
            });
            $stock = optional($trashCode->last() ?? null, function (string $stockCode) {
                return Stock::query()->firstWhere([
                    'shop_id' => $stockCode,
                ]);
            });

            if (is_a($stock, Stock::class) && is_a($product, Product::class)) {
                return optional(StockProduct::query()->firstWhere([
                        'stock_id' => $stock->id,
                        'product_id' => $product->id,
                    ]) ?? null, function (StockProduct $stockProduct) {
                    return $stockProduct;
                });
            }
        }
        return null;
    }

    public function getTrashCodeAttribute(): ?string
    {
        $stock = optional($this->stock()->first() ?? null, function (Stock $stock) {
            return $stock->shop_id;
        });

        $product = optional($this->product()->first() ?? null, function (Product $product) {
            return $product->elsie_code;
        });

        return !empty($stock) && !empty($product) ? implode('_', [
            $product, $stock,
        ]) : null;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }

    public function quantities(): HasMany
    {
        return $this->hasMany(StockProductQuantity::class, 'stock_product_id', 'id');
    }

    public function actual_quantity(): HasOne
    {
        return $this->hasOne(StockProductQuantity::class, 'stock_product_id', 'id')->latestOfMany()->withDefault([
            'quantity' => 0,
            'units' => 'pcs',
            'created_at' => Carbon::minValue(),
        ]);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return self::query()->find($value);
    }
}
