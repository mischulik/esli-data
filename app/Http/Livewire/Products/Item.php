<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Item extends Component
{
    public Product $product;

    public function render()
    {
        $this->product->refresh();
        return view('products.item');
    }
}
