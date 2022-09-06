<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

trait WithPlacement
{
    public array $placements = ['', 'A', 'B', 'R', 'L', 'F'];
    public string $selectedPlacement = '';

    public function updatedSelectedPlacement()
    {
        $this->validate([
            'selectedPlacement' => Rule::in($this->placements),
        ]);
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function queryPlacement(Builder $builder)
    {
        return $builder->when(!empty($this->selectedPlacement), function (Builder $builder) {
            $builder->whereRaw('`elsie_code` REGEXP ' . '"^[[:alnum:]]{4}' . $this->selectedPlacement . '[[:alnum:]]*-?[[:alnum:]]*$"');
        });
    }
}