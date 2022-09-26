<div class="list-group-item list-group-item-action mb-1">
    {{-- Success is as dangerous as failure. --}}
    <a class="text-decoration-none" href="{{ route('stock-products.show', [$stockProduct]) }}">
        <div class="d-inline-flex align-items-center justify-content-between w-100 py-2">
            <div class="flex-grow-1">
                <strong class="text-dark">
                    {{ $stockProduct->stock->name }}
                </strong>
            </div>
            <div class="flex-shrink-0">
                <strong class="text-success">
                    {{ $stockProduct->product->actual_price->price }}
                </strong>
                <small class="text-muted">
                    {{ $stockProduct->product->actual_price->currency }}
                </small>
            </div>
                <div class="flex-shrink-0">
                <span class="mx-2">
                    <span class="text-primary fw-bold">
                        {{ $stockProduct->actual_quantity->quantity }}
                    </span>
                    <span class="text-muted">{{ __($stockProduct->actual_quantity->units) }}</span>
                </span>
                    <i class="fas fa-history text-success"
                       title="{{ $stockProduct->actual_quantity->created_at->diffForHumans() }}">
                    </i>
                </div>
        </div>
    </a>
</div>
