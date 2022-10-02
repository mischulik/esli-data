<?php

namespace App\Http\Livewire;

use App\Actions\Data\ElsieSearchAction;
use App\Actions\ElsieSaveFound;
use App\Actions\ElsieSearchParse;
use App\Models\Product;
use App\Models\StockProduct;
use Bastinald\Ui\Traits\WithModel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ElsieSearch extends Component
{
    use WithModel;
    use WithPagination;

    public string $code = '';
    public string $descr = '';
    public $searchResults;

    public function updated()
    {
        $data = (strlen($this->code) > 4 || strlen($this->descr)) ? ElsieSearchAction::make()->handle([
            'code' => $this->code,
            'descr' => $this->descr,
        ]) : null;

        if ($data) {
            collect($data)->each(function (array $item) {
                $item['vehicle_id'] = null;
                ElsieSaveFound::run(ElsieSearchParse::run($item));
            });
            $this->emit('$refresh');
        }
    }

    public function render()
    {
        $this->searchResults = strlen($this->code) > 4 ? Product::query()->where('elsie_code', 'like', $this->code.'%')->get() : [];
        return view('elsie-search');
    }
}
