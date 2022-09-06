<?php

namespace App\Http\Livewire;

use Bastinald\Ui\Traits\WithModel;
use Livewire\Component;

class OffcanvasFilters extends Component
{
    use WithModel;

    public string $codeSearch = '';
    public string $nameSearch = '';

    public function mount(string $nameSearch = '', string $codeSearch = '')
    {
        $this->nameSearch = $nameSearch;
        $this->codeSearch = $codeSearch;

        $this->fill([
            'nameSearch' => $this->nameSearch,
            'codeSearch' => $this->codeSearch,
        ]);
    }

    public function render()
    {
        return view('offcanvas-filters')->with([
            'nameSearch' => $this->nameSearch,
            'codeSearch' => $this->codeSearch,
        ]);
    }

    public function updatedModel()
    {
        $this->codeSearch = $this->getModel('codeSearch') ?? '';
        $this->nameSearch = $this->getModel('nameSearch') ?? '';
    }

    public function accept()
    {
        $this->emit('$search', $this->validateModel([
            'nameSearch' => [
                'nullable', 'string'
            ],
            'codeSearch' => [
                'nullable', 'string'
            ],
        ]));
    }
}
