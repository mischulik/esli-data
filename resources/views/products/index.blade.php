@section('title', __('Products'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('products') }}" class="text-decoration-none text-black">
                    {{ __('Products') }}
                </a>
            </li>
        </ol>
    </nav>
    <h1>@yield('title')</h1>

    <div class="flex-wrap flex-sm-nowrap row justify-content-between mb-0 mb-sm-3">
        <div class="mb-3 mb-sm-0 col flex-sm-grow-1 flex-fill">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Products') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
        <div class="mb-3 mb-sm-0 w-sm-auto flex-sm-shrink-1 flex-fill form-floating">

            <div class="input-group flex-nowrap">
                @foreach($gaFilterValues as $scope)
                    <button class="btn flex-fill shadow-none {{ $selectedGaFilter === $scope ? 'btn-secondary' : 'btn-outline-secondary' }}"
                            type="button" wire:click="$set('selectedGaFilter', '{{ $scope }}')">
                    <span class="d-md-block d-none">
                        {{ __(ucfirst($scope)) }}
                    </span>
                        <span class="d-block d-md-none">
                        {{ __(ucfirst($scope)) }}
                    </span>
                    </button>
                @endforeach
            </div>

        </div>
    </div>
    <div class="flex-grow-1 mb-3">
        <div class="input-group flex-nowrap">
            @foreach($placements as $placement)
                <button class="btn flex-fill shadow-none {{ $selectedPlacement === $placement ? 'btn-secondary' : 'btn-outline-secondary' }}"
                        type="button" wire:click="$set('selectedPlacement', '{{ $placement }}')">
                    <span class="d-md-block d-none">
                        {{ __(implode(' ', ['Placement', $placement])) }}
                    </span>
                    <span class="d-block d-md-none">
                        {{ empty($placement) ? __('All') : $placement }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($products as $product)
            <livewire:products.item :product="$product"
                                    wire:key="{{ implode('_', ['product', $loop->index, $product->id]) }}"/>
        @empty
            <div class="list-group-item text-center">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$products"/>
</div>
