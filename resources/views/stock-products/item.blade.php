<div class="list-group-item list-group-item-action">
    <div class="d-inline-flex align-content-center-center justify-content-between w-100">
        <div class="flex-grow-0 mb-2 mb-lg-0">
            <a href="{{ route('stock-products.show', ['stockProduct' => $stockProduct]) }}"
               class="text-decoration-none text-dark">
                <ul class="list-unstyled mb-0">
                    <li>
                        <strong>{{ $stockProduct->product->elsie_code }}</strong> - {{ $stockProduct->product->name }}
                    </li>
                    <li>
                        <small class="text-secondary">
                            {{ $stockProduct->product->manufacturer ? $stockProduct->product->manufacturer->name : 'null' }}
                        </small>
                    </li>
                    @if($vehicle = $stockProduct->product->vehicle)
                        <li>
                            <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}" class="text-decoration-none"
                               title="{{ __('To vehicle page') }}">
                                <small class="text-secondary">
                                    {{ $vehicle->name }} ({{ $vehicle->year_start }}-{{ $vehicle->year_end }}
                                    ) {{ implode(', ', $vehicle->bodytypes) }}
                                </small>
                            </a>
                        </li>
                    @endif
                    @if(\Illuminate\Support\Facades\Route::currentRouteName() !== 'stock-products')
                        <li>
                            <a href="{{ route('stocks.show', ['stock' => $stockProduct->stock]) }}"
                               class="text-decoration-none" title="{{ __('To stock page') }}">
                                {{ $stockProduct->stock->name }}
                            </a>
                        </li>
                    @endif
                </ul>
            </a>
        </div>
        <div class="d-inline-flex flex-shrink-1 text-center">
            @if($quantity = $stockProduct->actual_quantity)
                <div class="d-block px-2">
                    <div>
                        <strong class="text-primary">
                            {{ $quantity->quantity}}
                        </strong>
                        <span>{{ __($quantity->units) }}</span>
                    </div>
                    <div>
                        <small class="text-secondary">
                            {{ now()->sub($quantity->created_at)->diffForHumans() }}
                        </small>
                    </div>
                </div>
            @endif
            <div class="d-block">
                <div>
                    <strong class="text-success">
                        {{ $stockProduct->product->actual_price->price }}
                    </strong>
                    <span>{{ __($stockProduct->product->actual_price->currency) }}</span>
                </div>
                <div>
                    <small class="text-secondary">
                        {{ $stockProduct->product->actual_price->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
