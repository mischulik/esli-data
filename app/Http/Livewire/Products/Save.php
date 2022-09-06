<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Bastinald\Ui\Traits\WithModel;
use Livewire\Component;

class Save extends Component
{
    use WithModel;

    public $product;

    public function mount(Product $product = null)
    {
        $this->product = $product;

        $this->setModel($product->toArray());
    }

    public function render()
    {
        return view('products.save');
    }

    public function save()
    {
        $this->validateModel($this->product->rules());

        $this->product->fill($this->getModel())->save();

        $this->emit('hideModal');
        $this->emit('$refresh');
    }
}
