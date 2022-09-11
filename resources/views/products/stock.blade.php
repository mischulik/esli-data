<div class="list-group-item list-group-item-action mb-1">
{{-- Success is as dangerous as failure. --}}
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-auto text-center">
            <a href="{{ route('stock-products.show', [$stockProduct]) }}" class="text-decoration-none fw-bold text-dark" title="{{ __('View :productId on stock :stockName', ['productId' => $stockProduct->product->elsie_code,'stockName' => $stock->name]) }}">
                {{ $stock->name }}
            </a>
        </div>
        <ul class="col-lg-auto text-center list-unstyled mb-0">
            <li>
                <span class="text-primary fw-bold">
                    {{ $actualQuantity->quantity }}
                </span>
                <span class="text-muted">{{ __('шт') }}</span>
            </li>
            <li>
               <small class="text-muted" title="{{ __('last updated') }}">
                   {{ $actualQuantity->created_at->diffForHumans() }}
               </small>
            </li>
        </ul>
    </div>
</div>
