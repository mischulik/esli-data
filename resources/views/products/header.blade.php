<div class="d-block">
    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>@yield('title')</h1>
            <p class="fs-3">{{ $product->name }}</p>
        </div>
        <div class="flex-shrink-1 text-center">
            @if($stockProduct = $product->stock_products()->first())
                @if($actualPrice = $stockProduct->prices()->latest()->first())
                    <h3 title="{{ $actualPrice->created_at->diffForHumans() }}">
                        <span class="text-success">
                            {{ $actualPrice->price }}
                        </span>
                        <small class="text-muted fw-light">
                            {{ $actualPrice->currency }}
                        </small>
                    </h3>
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
