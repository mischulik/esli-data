 <div class="list-group-item list-group-item-action">
    <div class="d-inline-flex align-items-center justify-content-between w-100">
        <div class="col-lg mb-2 mb-lg-0">
            <ul class="list-unstyled mb-0">
                <li>
                    <a href="{{ route('stocks.show', ['stock' => $stock]) }}"
                       class="text-decoration-none text-dark fw-bold"
                       title="{{ __('To stock\'s page') }}">
                        {{ $stock->name }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-auto">
            <a href="{{ route('stock-products', ['stock' => $stock]) }}" class="text-decoration-none" title="{{ __('To products on stock') }}">
                <div class="text-center">
                    <div class="text-dark fw-bolder">
                        {{ $itemsCount }}
                    </div>
                    <div class="text-secondary fw-lighter">
                        {{ __('products in stock') }}
                    </div>
                </div>
            </a>
        </div>
    </div>
 </div>
