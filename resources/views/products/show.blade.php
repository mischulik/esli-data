@section('title', $product->elsie_code)

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
            <li class="breadcrumb-item active">
                <a href="{{ route('products.show', ['product' => $product]) }}" class="text-decoration-none text-black">
                    {{ $product->elsie_code }}
                </a>
            </li>
        </ol>
    </nav>

    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>@yield('title')</h1>
            <h4>{{ $product->name }}</h4>
        </div>
        <div class="flex-shrink-1">
            @isset($actual_price)
                <h3 class="text-success">
                    {{ $actual_price  }}
                </h3>
            @endisset
        </div>
    </div>

    <div class="my-3 justify-content-around d-inline-flex w-100">
        @if($vehicle = $product->vehicle)
            <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}" class="text-decoration-none">
                <div class="d-flex align-items-center text-secondary">
                    <div class="flex-shrink-0">
                        <i class="fa fa-2x fa-car-alt text-secondary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div>{{ $vehicle->name }}
                            ({{ $vehicle->year_start }}-{{ $vehicle->year_stop ?? __('now') }})
                            {{ implode(', ', $vehicle->bodytypes) }}
                        </div>
                        <div>{{ $vehicle->code }}</div>
                    </div>
                </div>
            </a>
        @endif

        @if($manufacturer = $product->manufacturer)
            <a href="{{ route('manufacturers.show', ['manufacturer' => $manufacturer]) }}" class="text-decoration-none">
                <div class="d-flex align-items-center text-secondary">
                    <div class="flex-shrink-0">
                        <i class="fas fa-2x fa-industry text-secondary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        {{ $manufacturer->name }}
                        {{ $manufacturer->country }}
                        <small>
                            ({{ $manufacturer->code_suffix }})
                        </small>
                    </div>
                </div>
            </a>
        @endif
    </div>
    @forelse($stockProducts as $stockProduct)
        <livewire:stock-products.item :stockProduct="$stockProduct"
                                      wire:key="{{ implode('_', [$stockProduct->id, 'stock-product', now()->timestamp]) }}"/>
    @empty
    @endforelse
    @forelse($zeroProducts as $zeroProduct)
        <livewire:stock-products.item :stockProduct="$zeroProduct"
                                      wire:key="{{ implode('_', [$zeroProduct->id, 'stock-product', now()->timestamp]) }}"/>
    @empty
    @endforelse
</div>
