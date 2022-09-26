<?php

namespace App\Http\Livewire;

use App\Models\ElsieCredentials;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ElsieSearch extends Component
{
    use WithModel;
    use WithPagination;

    public ElsieCredentials $elsieCredentials;

    public string $codeSearch;
    public string $nameSearch;

    protected $listeners = [
        '$search' => 'search',
        '$refresh',
    ];

    public function mount(ElsieCredentials $elsieCredentials = null, string $codeSearch = '', string $nameSearch = '')
    {
        $this->elsieCredentials = $elsieCredentials;
        $this->codeSearch = $codeSearch ?? request()->query('code', '');
        $this->nameSearch = $nameSearch ?? request()->query('name', '');

        $this->fill([
            'codeSearch' => $this->codeSearch,
            'nameSearch' => $this->nameSearch,
        ]);
    }

    public function render()
    {
        return view('elsie-search')->with([
            'code' => $this->codeSearch,
            'name' => $this->nameSearch,
            'results' => $this->query()->paginate(),
        ]);
    }

    public function search()
    {
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function query()
    {
        $this->codeSearch = '3003';

        return Stock::query()->whereHas('products', function (Builder $builder) {
            $builder->when(!empty($this->codeSearch), function (Builder $builder) {
                $builder->where('elsie_code', 'like', $this->codeSearch . '%');
            })->when(!empty($this->nameSearch), function (Builder $builder) {
                $builder->where('name', 'like', '%' . $this->nameSearch . '%');
            })->whereHas('stock_products', function(Builder $builder) {
                $builder
                    ->whereHas('quantities');
            })->whereHas('prices');
        });
    }
}
