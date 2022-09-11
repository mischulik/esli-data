<?php

namespace App\Models;

use App\Actions\Data\ElsieSearchAction;
use App\Actions\ElsieSearchParse;
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

    protected static function booted()
    {
        parent::booted(); // TODO: Change the autogenerated stub

        static::created(function (Vehicle $vehicle) {
            collect([
                'A',
                'B',
                'R',
                'L',
            ])->each(function (string $type) use ($vehicle) {
                $data = ElsieSearchAction::make()->handle(implode('', [
                    $vehicle->code,
                    $type,
                ]), User::find(1)->elsie_credentials->id);
                $data1 = $data[0] ?? null;
                if (is_array($data1)) {
                    $data1 = $data1[0] ?? null;
                    if ($data1 == 'message') {
                        return;
                    }
                }
                collect($data)->each(function (array $searchResult) use ($vehicle) {
                    $searchResult['vehicle_id'] = $vehicle->id;
                    ElsieSearchParse::run($searchResult);
                });
            });
        });
    }

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
