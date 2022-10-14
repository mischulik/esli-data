<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'products';

    protected $fillable = [
        'manufacturer_id',
        'vehicle_id',
        'name',
        'stock_code',
        'elsie_code',
        'width',
        'height',
        'search_name',
        'note',
    ];

    protected $with = [
//        'actual_price',
//        'prices',
    ];

    protected $withCount = [
        'prices',
    ];

    public function newQuery()
    {
        return parent::newQuery()->with([
            'actual_price',
            'stock_products',
        ])
//            ->withSum('stock_products', 'actual_quantity_quantity')
            ->select('*')
            ->addSelect([
                'actual_price_price' => ProductPrice::query()
                    ->select('price')
                    ->whereColumn('product_prices.product_id', 'products.id')
                    ->latest()->take(1)
            ])->addSelect([
                'actual_price_currency' => ProductPrice::query()
                    ->select('currency')
                    ->whereColumn('product_prices.product_id', 'products.id')
                    ->latest()->take(1)
            ])->addSelect([
                'actual_price_date' => ProductPrice::query()
                    ->select('created_at')
                    ->whereColumn('product_prices.product_id', 'products.id')
                    ->latest()
                    ->take(1)
            ]);
    }

    public function scopeDefected(Builder $builder): Builder
    {
        return $builder->where('elsie_code', 'like', '%.%');
    }

    public function scopeGlasses(Builder $builder): Builder
    {
        return $builder->whereRaw('`elsie_code` NOT REGEXP "^[[:alnum:]]{5}[S,K,X]{1}[[:alnum:]]*-?[[:alnum:]]*$"');
    }

    public function scopeAccessories(Builder $builder): Builder
    {
        return $builder->whereRaw('`elsie_code` REGEXP "^[[:alnum:]]{5}[S,K,X]{1}[[:alnum:]]*-?[[:alnum:]]*$"');
    }

    public static function suggestedManufacturer(string $suffix): ?Manufacturer
    {
        return optional(Manufacturer::query()->firstWhere([
                'code_suffix' => $suffix,
            ]) ?? null, function (Manufacturer $manufacturer) {
            return $manufacturer;
        });
    }

    public static function parseCode(string $elsieCode): ?array
    {
        $parsed = collect(explode('.', $elsieCode));
        $productCode = $parsed->first();
        $defectCode = $parsed->count() === 2 ? $parsed->last() : null;
        $parsed = collect(explode('-', $productCode));
        $productCode = $parsed->first();
        $manufacturerCode = $parsed->count() === 2 ? $parsed->last() : null;
        $vehicleCode = substr($productCode, 0, 4);

        return [
            'product_code' => $productCode,
            'vehicle_code' => $vehicleCode,
            'defect_code' => $defectCode,
            'manufacturer_code' => $manufacturerCode,
        ];
    }

    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'stock_products', 'product_id', 'stock_id', 'id', 'id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }

    public function stock_products(): HasMany
    {
        return $this->hasMany(StockProduct::class, 'product_id', 'id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'product_id', 'id');
    }

    public function actual_price(): HasOne
    {
        return $this->hasOne(ProductPrice::class, 'product_id', 'id')->latestOfMany()->withDefault([
            'price' => 0,
            'currency' => 'UAH',
            'created_at' => Carbon::minValue(),
        ]);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->stock_products()->with('actual_quantity')->get()->map(function (StockProduct $stockProduct) {
            return $stockProduct->actual_quantity;
        })->sum(function (StockProductQuantity  $stockProductQuantity) {
            return $stockProductQuantity->quantity;
        });
    }

//    public function newQuery()
//    {
//        return parent::query(), 'total_quantity')->getQuery();
//    }
}
