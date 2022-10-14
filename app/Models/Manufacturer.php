<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Manufacturer extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'manufacturers';

    protected $fillable = [
        'code_suffix',
        'name',
        'country',
    ];

    protected $withCount = [
//        'glasses',
//        'accessories',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'manufacturer_id', 'id');
    }

    public function glasses()
    {
        return $this->products()->glasses();
    }

    public function accessories()
    {
        return $this->products()->accessories();
    }
}
