<div>
    <div class="list-group-item list-group-item-action">
        <div class="row align-items-center">
            <div class="col-lg mb-2 mb-lg-0">
                <ul class="list-unstyled mb-0">
                    <li class="mb-1">
                        <a href="{{ route('products.show', ['product' => $product]) }}"
                           class="text-decoration-none text-dark" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="{{ __('Go to product').' '.$product->name }}">
                            <strong>{{ $product->elsie_code }}</strong>
                            @isset($product->stock_code)<span>({{ $product->stock_code }})</span>@endisset
                            <span class="fw-light">{{ $product->manufacturer->name }}</span>
                            @if($product->size)<span>{{ $product->size }}</span>@endif
                        </a>
                    </li>
                    <li class="mb-1">
                        <span class="text-dark">
                            {{ $product->search_name ?? $product->name }}
                        </span>
                    </li>
                    @if($product->note)
                        <li class="mb-1">
                            <small class="text-secondary">
                                {{ $product->note }}
                            </small>
                        </li>
                    @endif
                    @if(!$product->search_name)
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() != 'vehicles.show')
                            <li class="mb-1">
                                @if($vehicle = $product->vehicle)
                                    <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}"
                                       class="text-decoration-none">
                                        <span class="text-dark">
                                    {{ $vehicle->name }} ({{ $vehicle->year_start }}
                                    -{{ $vehicle->year_end ?? __('now') }})
                                    {{ implode(', ', $vehicle->bodytypes) }}
                                </span>
                                    </a>
                                @endif
                            </li>
                        @endif
                    @endif
                    <li>
                        <div class="row justify-content-start">
                            @forelse($product->stock_products as $stockProduct)
                                <span class="badge bg-primary text-white col-auto mx-2">
                                <a href="{{ route('stock-products.show', ['stockProduct' => $stockProduct]) }}"
                                   class="text-decoration-none text-white"
                                   title="{{ __('View :productId on stock :stockName', ['productId' => $product->elsie_code, 'stockName' => $stockProduct->stock->name]) }}">
                                    {{ $stockProduct->stock->name }} ({{ $stockProduct->actualQuantity->quantity }})
                                </a>
                            </span>
                            @empty
                            @endforelse
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-auto text-center">
                <div>
                    <strong class="text-success">
                        {{ $price->price }}
                    </strong>
                    <small class="text-success">
                        {{ __($price->currency) }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
