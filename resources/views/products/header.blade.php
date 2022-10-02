<div class="d-block">
    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>{{ $product->elsie_code }}</h1>
            <p class="fs-3">{{ $product->name }}</p>
        </div>
        <div class="flex-shrink-0 text-end">
                    <strong class="text-success fs-3" title="{{ $product->actual_price->created_at->diffForHumans() }}">
                        {{ $product->actual_price->price }}
                    </strong>
                    <small class="text-muted fw-light">
                        {{ $product->actual_price->currency }}
                    </small>
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
