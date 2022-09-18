<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Header extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('products.header');
    }
}
