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
        <div class="flex-shrink-1 text-center">
{{--            @isset($actual_price)--}}
{{--                <h3 class="text-success">--}}
{{--                    {{ $actual_price  }}--}}
{{--                </h3>--}}
{{--                <small></small>--}}
{{--            @endisset--}}
            <h3 class>
                <span class="text-success">
                    {{ $actualPrice->price }}
                </span>
                <small class="text-muted fw-light">
                    {{ $actualPrice->currency }}
                </small>
            </h3>
            <small class="text-muted">
                {{ $actualPrice->created_at->diffForHumans() }}
            </small>

        </div>
    </div>

    <div class="my-3 d-inline-flex w-100">
        @if($vehicle = $product->vehicle)
            <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}" class="text-decoration-none col" title="{{ __('View all products of :vehicleName', ['vehicleName' => $vehicle->full_name]) }}">
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
            <a href="{{ route('manufacturers.show', ['manufacturer' => $manufacturer]) }}" class="text-decoration-none col" title="{{ __('View all products by :manufacturerName', ['manufacturerName' => $manufacturer->name]) }}">
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
    <div class="list-group mb-3">
    @forelse($stockProducts as $stockProduct)
        <livewire:products.stock :stock-product="$stockProduct" />
    @empty
        <div>
            {{ __('No info available') }}
        </div>
    @endforelse
    </div>
</div>
