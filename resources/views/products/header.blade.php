<div class="d-block">
    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>{{ $product->elsie_code }}</h1>
            <p class="fs-3">{{ $product->name }}</p>
        </div>
        <div class="flex-shrink-0 text-end">
            @if($stockProduct = $product->stock_products()->first())
                @if($actualPrice = $stockProduct->prices()->latest()->first())
                    <strong class="text-success fs-3" title="{{ $actualPrice->created_at->diffForHumans() }}">
                        {{ $actualPrice->price }}
                    </strong>
                    <small class="text-muted fw-light">
                        {{ $actualPrice->currency }}
                    </small>
                @endif
            @endif
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
