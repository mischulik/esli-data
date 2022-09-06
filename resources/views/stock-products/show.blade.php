@section('title', $stockProduct->product->elsie_code.' - '.$stockProduct->stock->name)

@push('styles')
@endpush

@push('scripts')
    <script src="//unpkg.com/alpinejs"></script>
@endpush

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('products') }}" class="text-decoration-none text-secondary">
                    {{ __('Products') }}
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('products.show', ['product' => $stockProduct->product]) }}"
                   class="text-decoration-none text-secondary">
                    {{ $stockProduct->product->elsie_code }}
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('stocks.show', ['stock' => $stockProduct->stock]) }}"
                   class="text-decoration-none text-secondary">
                    {{ $stockProduct->stock->name }}
                </a>
            </li>
        </ol>
    </nav>

    <div class="d-inline-flex justify-content-md-between align-items-center w-100 mb-5">
        <div class="flex-grow-1">
            <h1>@yield('title')</h1>
            <h5>{{ $stockProduct->product->name }}</h5>
            @if($vehicle = $stockProduct->product->vehicle)
            <h6>{{ $vehicle->full_name }}</h6>
            @endif
        </div>
        <div class="flex-fill justify-content-end">
            @if($actualPrice = $stockProduct->actual_price)
                <div class="d-block mb-1">
                    <div class="d-flex justify-content-between" title="{{now()->sub($actualPrice->created_at)->longRelativeToNowDiffForHumans() }}">
                        <small class="text-secondary">
                            {{ __('Last known price') }}
                        </small>
                        <strong class="text-success">
                            {{ $actualPrice->price }} {{ $actualPrice->currency }}
                        </strong>
                    </div>
                </div>
            @endif
            @if($actualQuantity = $stockProduct->actual_quantity)
                <div class="d-block mb-1">
                    <div class="d-flex justify-content-between"
                         title="{{ now()->sub($actualQuantity->created_at)->shortRelativeToNowDiffForHumans() }}">
                        <small class="text-secondary">
                            {{ __('Last known quantity') }}
                        </small>
                        <strong class="text-primary">
                            {{ $actualQuantity->quantity }}
                        </strong>
                    </div>
                </div>
            @endif
            <div class="d-block mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">{{ __('For fresh data click') }}</small>
                    <a type="button" class="btn btn-link text-decoration-none" wire:loading.class="disabled"
                       wire:click="getStockProductInfo">
                        <div class="spinner-border visually-hidden" role="status"
                             wire:loading.class.remove="visually-hidden"
                             wire:loading.target="getStockProductInfo">
                        </div>
                        <i class="fa fa-2x fa-sync" wire:loading.class="visually-hidden"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @forelse($stockProduct->quantities as $quantity)
        <div>
            {{ $quantity->quantity }}
        </div>
    @empty
    @endforelse

    @forelse($stockProduct->prices as $price)
        <div>
            {{ $price->price }}
        </div>
    @empty
    @endforelse

</div>
