@section('title', $manufacturer->name.' '.__('products'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('manufacturers') }}" class="text-decoration-none text-secondary">
                    {{ __('Manufacturers') }}
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('manufacturers.show', ['manufacturer' => $manufacturer]) }}"
                   class="text-decoration-none text-black">
                    {{ $manufacturer->name }}
                </a>
            </li>
        </ol>
    </nav>

    <h1>@yield('title')</h1>
    <div class="flex-wrap flex-sm-nowrap d-flex justify-content-between mb-0 mb-sm-3">
        <div class="mb-3 mb-sm-0 col flex-sm-grow-1 flex-fill">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Products') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
        <div class="mb-3 mb-sm-0 w-sm-auto flex-sm-shrink-1 flex-fill">
            <div class="dropdown">
                <input class="form-control shadow-none" placeholder="{{ $this->getSelectedGaFilter()  }}"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                <ul class="dropdown-menu">
                    @forelse($gaFilterValues as $scope)
                        <li>
                            <label class="dropdown-item"
                                   wire:click="$set('selectedGaFilter', '{{ ucfirst($scope) }}')">
                                {{ __(ucfirst($scope)) }}
                            </label>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="flex-grow-1 mb-3">
        <div class="input-group flex-nowrap">
            @foreach($placements as $placement)
                <button class="btn flex-fill shadow-none {{ $selectedPlacement === $placement ? 'btn-secondary' : 'btn-outline-secondary' }}"
                        type="button" wire:click="$set('selectedPlacement', '{{ $placement }}')">
                    {{ __(implode(' ', ['Placement', $placement])) }}
                </button>
            @endforeach
        </div>
    </div>


    <div class="list-group mb-3">
        @forelse($products as $product)
            <livewire:products.item :product="$product"
                                    wire:key="{{ implode('_', ['product', $loop->index, $product->id]) }}"
            />
        @empty
        @endforelse
    </div>

    <x-ui::pagination :links="$products"/>
</div>
