<div class="list-group-item list-group-item-action mb-1">
    {{-- Success is as dangerous as failure. --}}
    <a class="text-decoration-none" href="{{ route('stock-products.show', [$stockProduct]) }}">
        <div class="d-inline-flex align-items-center justify-content-between w-100 py-2">
            <div class="flex-grow-1">
                <strong class="text-dark">
                    {{ $stock->name }}
                </strong>
            </div>
            @if($stockProduct->actualPrice->price)
                <div class="flex-shrink-0">
                    <strong class="text-success">
                        {{ $stockProduct->actualPrice->price }}
                    </strong>
                    <small class="text-muted">
                        {{ $stockProduct->actualPrice->currency }}
                    </small>
                </div>
            @endif
            @if($stockProduct->actualQuantity->quantity)
                <div class="flex-shrink-0">
                <span class="mx-2">
                    <span class="text-primary fw-bold">
                        {{ $stockProduct->actualQuantity->quantity }}
                    </span>
                    <span class="text-muted">{{ __($stockProduct->actualQuantity->units) }}</span>
                </span>
                    <i class="fas fa-history text-success"
                       title="{{ $stockProduct->actualQuantity->created_at->diffForHumans() }}"></i>
                </div>
            @else
                <button class="btn btn-primary shadow-none" wire:click="$refresh()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            @endif
        </div>
    </a>
</div>
