<div class="d-block" wire:init="getProductInfo">
    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>{{ $product->elsie_code }}</h1>
            <p class="fs-3">{{ $product->name }}</p>
        </div>
        <div class="flex-shrink-0 text-end">
            <div class="mb-1">
                <strong class="text-success fs-3" title="{{ $product->actual_price->created_at->diffForHumans() }}">
                    {{ $product->actual_price->price }}
                </strong>
                <small class="text-muted fw-light">
                        {{ $product->actual_price->currency }}
                    </small>
            </div>
            <div>
                <div class="align-content-end mb-1">
                    <strong class="text-primary fs-3">
                    {{ $product->total_quantity }}
                </strong>
                    <small class="text-muted fw-light">
                    {{ __('pcs') }}
                </small>
                </div>
                <div class="d-block">
                    @forelse($product->stock_products as $stockProduct)
                        <a class="btn btn-primary w-100 mb-2 shadow-none" type="button" href="{{ route('stock-products.show', [$stockProduct]) }}" title="{{ __('Подробнее о товаре :productName на складе :stockName', ['productName' => $product->elsie_code, 'stockName' => $stockProduct->stock->name, ]) }}">
                            {{ $stockProduct->stock->name }} ({{ $stockProduct->actual_quantity->quantity }})
                        </a>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="my-3 row">
        @if($vehicle = $product->vehicle)
            <livewire:products.vehicle :vehicle="$vehicle" />
        @endif

        @if($manufacturer = $product->manufacturer)
            <livewire:products.manufacturer :manufacturer="$manufacturer" />
        @endif
    </div>
</div>
