<div>
    <div class="d-inline-flex p-3 w-100 justify-content-between align-items-center">
        <div class="flex-grow-1">
            <a href="{{ route('stock-products.show', ['stockProduct' => $stockProduct]) }}"
               class="text-decoration-none">
                <div class="flex-grow-1 d-inline-flex">
                    <div class="flex-shrink-1">
                        <i class="fa fa-home {{ $stockProduct->prices_count ? 'text-success' : 'text-secondary' }}"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-dark">
                            {{ $stock->name }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="d-inline-flex flex-nowrap">
            <a type="button"
               class="btn btn-link text-decoration-none"
               title="{{ __('Click to refresh') }}"
               data-bs-toggle="tooltip"
               wire:loading.class="disabled"
               wire:click="getStockProductInfo">
                <div class="fw-bold text-primary {{ $quantity < 0 ? 'visually-hidden' : '' }}"  wire:loading.class="visually-hidden">
                    {{ $quantity }} <span class="fw-light">{{ __('pcs') }}</span>
                </div>

                <div class="spinner-border spinner-border-sm text-secondary visually-hidden" role="status"
                     wire:loading.class.remove="visually-hidden"
                     wire:loading.target="getStockProductInfo">
                </div>
                <small class="text-secondary fw-light" wire:loading.class="visually-hidden">{{ __('refresh') }}</small>
            </a>
        </div>
    </div>
</div>
