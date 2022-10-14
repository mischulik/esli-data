@section('title', $stockProduct->product->elsie_code.' - '.$stockProduct->stock->name)

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted" title="{{ __('Home') }}">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('products') }}" class="text-decoration-none text-muted" title="{{ __('All Products') }}">
                    {{ __('Products') }}
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('products.show', ['product' => $stockProduct->product]) }}"
                   class="text-decoration-none text-muted"
                   title="{{ __('To :productName page', ['productName' => $stockProduct->product->elsie_code]) }}"
                >
                    {{ $stockProduct->product->elsie_code }}
                </a>
            </li>

            <li class="breadcrumb-item active text-dark" aria-current="page">
                <a href="{{ route('stock-products.show', [ 'stockProduct' => $stockProduct, ])  }}"
                   class="text-decoration-none text-secondary"
                   title="{{ __(':productName on stock :stockName', ['productName' => $stockProduct->product->elsie_code, 'stockName' => $stockProduct->stock->name, ]) }}"
                >
                    {{ $stockProduct->stock->name }}
                </a>
            </li>
        </ol>
    </nav>

{{--    <livewire:stock-products.header :stockProduct="$stockProduct" />--}}

    @livewire('products.header', ['product' => $stockProduct->product])

{{--    @if ($stockProduct->quantities_count > 1)--}}
    @livewire('stock-products.quantities-chart', ['stockProduct' => $stockProduct, 'title' => __('Quantities of a :productName on :stockName', ['productName' => $stockProduct->product->elsie_code, 'stockName' => $stockProduct->stock->name, ])])
{{--    @endif--}}
</div>
