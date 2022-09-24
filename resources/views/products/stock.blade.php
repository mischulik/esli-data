<div class="list-group-item list-group-item-action mb-1">
{{-- Success is as dangerous as failure. --}}
    <a class="text-decoration-none" href="{{ route('stock-products.show', [$stockProduct]) }}">
        <div class="d-inline-flex align-items-center justify-content-between w-100 py-2">
            <div class="flex-grow-1">
                <strong class="text-dark">
                    {{ $stock->name }}
                </strong>
            </div>
            <div class="flex-shrink-0">
                <span class="mx-2">
                    <span class="text-primary fw-bold">
                {{ $actualQuantity->quantity }}
            </span>
                    <span class="text-muted">{{ __('шт') }}</span>
                </span>
                @if($actualQuantity->created_at->isCurrentDay())
                    <i class="fas fa-history text-success" title="{{ $actualQuantity->created_at->diffForHumans() }}"></i>
                @else
                    <button class="btn btn-primary shadow-none" wire:click="$refresh()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                @endif
            </div>
        </div>
    </a>
</div>
