<div class="d-block">
    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>@yield('title')</h1>
            <p class="fs-3">{{ $stockProduct->product->name }}</p>
        </div>
        <div class="flex-shrink-1 text-center">
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
            @if($actualQuantity = $stockProduct->quantities()->latest()->first())
                <h3 title="{{ $actualQuantity->created_at->diffForHumans() }}">
                    <span class="text-primary">
                        {{ $actualQuantity->quantity }}
                    </span>
                    <small class="text-muted fw-light">
                        {{ __('шт') }}
                    </small>
                </h3>
            @endif
            <div class="align-content-center">
                <button class="btn btn-primary" wire:click="getInfo" title="{{ __('Refresh data') }}">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        @if($vehicle = $stockProduct->product->vehicle)
            <livewire:products.vehicle :vehicle="$vehicle" />
        @endif

        @if($manufacturer = $stockProduct->product->manufacturer)
            <livewire:products.manufacturer :manufacturer="$manufacturer" />
        @endif
    </div>

    <div class="mb-3">
        <p class="mb-0 text-muted">{{ __('Also available on:') }}</p>
        <div class="d-inline-flex justify-content-around">
        @forelse(\App\Models\StockProduct::whereNotIn('id', [$stockProduct->id])->where(['product_id' => $stockProduct->product_id])->get() as $sp)
            <a href="{{ route('stock-products.show', [$sp]) }}" class="text-decoration-none text-dark fw-bold">
                {{ $sp->stock->name }}
            </a>
        @empty
        @endforelse
        </div>
    </div>
</div>
