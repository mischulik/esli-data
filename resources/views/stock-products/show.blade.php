@section('title', $stockProduct->product->elsie_code.' - '.$stockProduct->stock->name)

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

            <li class="breadcrumb-item">
                <a href="{{ route('products.show', ['product' => $stockProduct->product]) }}"
                   class="text-decoration-none text-secondary">
                    {{ $stockProduct->product->elsie_code }}
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('stocks.show', ['stock' => $stockProduct->stock]) }}"
                   class="text-decoration-none text-secondary">
                    {{ $stockProduct->stock->name }}
                </a>
            </li>
        </ol>
    </nav>

    <livewire:stock-products.header :stockProduct="$stockProduct" />

    @livewire(\App\Http\Livewire\StockProducts\PricesChart::class, ['stockProduct' => $stockProduct, 'title' => __('Price Dynamic')])
    @livewire(\App\Http\Livewire\StockProducts\QuantitiesChart::class, ['stockProduct' => $stockProduct, 'title' => __('Quantities')])

</div>
