<div class="d-block">
    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>{{ $stockProduct->product->elsie_code }} - {{ $stockProduct->stock->name }}</h1>
            <p class="fs-3">{{ $stockProduct->product->name }}</p>
        </div>
        <div class="flex-shrink-0 text-end">
            @if($actualPrice = $stockProduct->prices()->latest()->first())
                <div>
                <strong class="text-success fs-3" title="{{ $actualPrice->created_at->diffForHumans() }}">
                    {{ $actualPrice->price }}
                </strong>
                <small class="text-muted fw-light">
                    {{ $actualPrice->currency }}
                </small>
                </div>
            @endif
            @if($actualQuantity = $stockProduct->quantities()->latest()->first())
                <div>
                <strong class="text-primary fs-3" title="{{ $actualQuantity->created_at->diffForHumans() }}">
                        {{ $actualQuantity->quantity }}
                </strong>
                <small class="text-muted fw-light">
                    {{ __('шт') }}
                </small>
                </div>
            @endif
            <div class="d-flex">
                <button class="flex-grow-1 btn btn-primary shadow-none" wire:click="getInfo" title="{{ __('Refresh data') }}" wire:loading.class="disabled">
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
