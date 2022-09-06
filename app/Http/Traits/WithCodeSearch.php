<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithCodeSearch
{
    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function queryCodeSearch(Builder $builder): Builder
    {
        return $builder->where(function (Builder $builder) {
            $builder->orWhere('elsie_code', 'like', $this->search . '%')
                ->orWhereHas('vehicle', function (Builder $builder) {
                    return $builder->where('name', 'like', '%' . $this->search . '%');
                });
        });
    }
}