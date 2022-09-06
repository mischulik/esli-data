<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vehicle extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'vehicles';

    protected $fillable = [
        'code',
        'name',
        'full_name',
        'bodytypes',
        'year_start',
        'year_end',
    ];

    protected $casts = [
        'bodytypes' => 'array',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vehicle_id', 'id');
    }

    public function getYearsAttribute(): array
    {
        return optional($this->year_end ?? null, function (int $year) {
                return range($this->year_start, $year);
            }) ?? range($this->year_start, now()->year);
    }
}
