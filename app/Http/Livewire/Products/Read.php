<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Read extends Component
{
    public $product;

    public function mount(Product $product = null)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('products.read');
    }
}
