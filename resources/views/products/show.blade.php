@section('title', $product->elsie_code)

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('products') }}" class="text-decoration-none text-secondary">
                    {{ __('Products') }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('products.show', ['product' => $product]) }}" class="text-decoration-none text-black">
                    {{ $product->elsie_code }}
                </a>
            </li>
        </ol>
    </nav>

    <livewire:products.header :product="$product" />

    <div class="list-group mb-3">
    @forelse($product->stock_products()->present()->get() as $stockProduct)
        <livewire:products.stock :stock-product="$stockProduct" />
    @empty
        <div>
            {{ __('No info available') }}
        </div>
    @endforelse
    </div>
</div>
