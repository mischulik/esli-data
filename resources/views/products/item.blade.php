<div>
    <div class="list-group-item list-group-item-action">
        <div class="d-inline-flex w-100">
            <div class="flex-grow-1 align-items-center">
                <ul class="list-unstyled mb-0">
                    <li class="mb-0 mb-md-1 mb-lg-1 mb-xl-1">
                        <a href="{{ route('products.show', ['product' => $product]) }}"
                           class="text-decoration-none text-dark" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="{{ __('Go to product').' '.$product->name }}">
                            <strong>{{ $product->elsie_code }}</strong>
                            @isset($product->stock_code)<span>({{ $product->stock_code }})</span>@endisset
                            @if($manufacturer = $product->manufacturer)<span class="fw-light">{{ $manufacturer->name }}</span>@endif
                            @if($product->size)<span>{{ $product->size }}</span>@endif
                        </a>
                    </li>
                    <li class="mb-0 mb-md-1 mb-lg-1 mb-xl-1 d-none d-md-block d-lg-block d-xl-block">
                        <span class="text-dark">
                            {{ $product->name }}
                        </span>
                    </li>
                    @if($product->note)
                        <li class="mb-1">
                            <small class="text-secondary">
                                {{ $product->note }}
                            </small>
                        </li>
                    @endif
{{--                    @if(!$product->search_name)--}}
{{--                        @if(\Illuminate\Support\Facades\Route::currentRouteName() != 'vehicles.show')--}}
{{--                            <li class="mb-1 d-none d-md-block d-lg-block">--}}
{{--                            @if($vehicle = $product->vehicle)--}}
{{--                                <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}"--}}
{{--                                   class="text-decoration-none">--}}
{{--                                <span class="text-dark">--}}
{{--                                    {{ $vehicle->name }} ({{ $vehicle->year_start }}--}}
{{--                                    -{{ $vehicle->year_end ?? __('now') }})--}}
{{--                                    {{ implode(', ', $vehicle->bodytypes) }}--}}
{{--                                </span>--}}
{{--                                </a>--}}
{{--                            @endif--}}
{{--                        </li>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                    <li class="mb-1 d-none d-md-block d-lg-block">--}}
{{--                        <div class="row justify-content-start">--}}
{{--                        @forelse($product->stock_products as $stockProduct)--}}
{{--                            @if ($stockProduct->actual_quantity)--}}
{{--                                <span class="badge bg-primary text-white col-auto mx-2">--}}
{{--                                <a href="{{ route('stock-products.show', ['stockProduct' => $stockProduct]) }}" class="text-decoration-none text-white" title="{{ __('View :productId on stock :stockName', ['productId' => $product->elsie_code, 'stockName' => $stockProduct->stock->name]) }}">--}}
{{--                                    {{ $stockProduct->stock->name }} ({{ $stockProduct->actual_quantity->quantity }})--}}
{{--                                </a>--}}
{{--                                </span>--}}
{{--                            @endif--}}
{{--                        @empty--}}
{{--                        @endforelse--}}
{{--                        </div>--}}
{{--                    </li>--}}
                </ul>
            </div>
            <div class="flex-shrink-0 align-self-center mx-3">
                <div class="btn-group">
                    <button type="button" class="btn border-0 shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <strong class="text-primary">{{ $product->total_quantity }}</strong>
                        <small class="text-success">{{ __('pcs') }}</small>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-lg-end">
                        @forelse($stockProducts as $stockProduct)
                            <li>
                                <a class="dropdown-item d-inline-flex justify-content-between" href="{{ route('stock-products.show', [$stockProduct]) }}">
                                    <span class="fw-normal">
                                        {{ $stockProduct->stock->name }}
                                    </span>
                                    <div>
                                        <span class="text-primary fw-bold">
                                            {{ $stockProduct->actual_quantity->quantity }}
                                        </span>
                                        <span class="text-muted fw-light">
                                            {{ __($stockProduct->actual_quantity->units) }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="flex-shrink-0 align-self-center">
                <strong class="text-success">{{ $product->actual_price->price }}</strong>
                <small class="text-success">{{ __($product->actual_price->currency) }}</small>
            </div>
        </div>
    </div>
</div>
