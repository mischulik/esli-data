<?php

namespace App\Http\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

trait WithGlassAccessoryFilter
{
    public array $gaFilterValues = [
        'glasses',
        'accessories',
    ];
    public string $selectedGaFilter = 'glasses';

    public function getSelectedGaFilter(): string
    {
        return __(ucfirst($this->selectedGaFilter));
    }

    public function updatedSelectedGaFilter()
    {
        $this->validate([
            'selectedGaFilter' => Rule::in($this->gaFilterValues),
        ]);

        $this->emitUp('$search', [
            'selectedGaFilter' => $this->selectedGaFilter,
        ]);
    }

    public function queryGaFilter(Builder $builder)
    {
        return $builder->when(!empty($this->selectedGaFilter), function (Builder $builder) {
            $method = $this->selectedGaFilter;

            if (method_exists(new Product, implode('', ['scope', ucfirst($method)]))) {
                $builder->$method();
            }
        });
    }
}
