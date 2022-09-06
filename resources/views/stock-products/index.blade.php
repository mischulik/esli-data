@section('title', implode(' ', [$stock->name, __('Products')]))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('stocks.show', ['stock' => $stock]) }}" class="text-decoration-none text-secondary">
                    {{ $stock->name }}
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('stock-products', ['stock' => $stock]) }}" class="text-decoration-none text-black">
                    {{ __('Products') }}
                </a>
            </li>
        </ol>
    </nav>
    <h1 class="mb-3">@yield('title')</h1>

    <div class="d-block">
        <div class="flex-sm-wrap flex-md-nowrap row justify-content-between mb-3">
            <div class="col-md-5 col-lg-4 col-sm-12 mb-3 mb-md-0">
                <div class="input-group flex-nowrap">
                        <span class="input-group-text">
                            <i class="fa fa-barcode"></i>
                        </span>
                    <input type="search" placeholder="{{ __('Search by code') }}"
                           class="form-control text-uppercase shadow-none" wire:model="code">

                </div>
            </div>
            <div class="col-md-7 col-lg-8 col  col-sm-12 ">
                <div class="input-group flex-nowrap">
                        <span class="input-group-text">
                            <i class="fa fa-shopping-bag text-secondary"></i>
                        </span>
                    <input type="search" placeholder="{{ __('Search by name') }}"
                           class="form-control text-uppercase shadow-none" wire:model="name">
                </div>
            </div>
        </div>
        <div class="flex-sm-wrap flex-md-nowrap row justify-content-between mb-3">
            <div class="col-md-5 col-lg-4 col-sm-12 mb-3 mb-md-0">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text">
                        <i class="fa fa-industry text-secondary"></i>
                    </span>
                    <select wire:model="manufacturerId" class="form-control shadow-none">
                        <option value="0" class="text-muted">{{ __('All') }}</option>
                        @forelse(\App\Models\Manufacturer::all() as $manufacturer)
                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-7 col-lg-8 col  col-sm-12 ">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text">
                            <i class="fa fa-car text-secondary"></i>
                    </span>
                    <input type="search" placeholder="{{ __('Search by vehicle') }}" class="form-control text-uppercase shadow-none" wire:model="vehicle">
                </div>
            </div>
        </div>
        <div class="flex-sm-wrap flex-md-nowrap row justify-content-between mb-3">
            <div class="col">
            <div class="form-check form-switch">
                <input class="form-check-input shadow-none" type="checkbox" id="show_filled" wire:model="showFilled">
                <label class="form-check-label" for="show_filled">
                    {{ __('Show only presented') }}
                </label>
            </div>
            </div>
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($stockProducts as $stockProduct)
            <livewire:stock-products.item :stock-product="$stockProduct"
                                          wire:key="stock_{{ $stockProduct->id }}_{{ now()->timestamp }}"/>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$stockProducts"/>
</div>
