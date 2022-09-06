@section('title', __('Stocks'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('stocks') }}" class="text-decoration-none text-black">
                    {{ __('Stocks') }}
                </a>
            </li>
        </ol>
    </nav>
    <h1>@yield('title')</h1>

    <div class="mb-3">
        <div class="input-group mb-3">
            <span class="input-group-text"><x-ui::icon name="search"/></span>
            <input type="search" placeholder="{{ __('Search Stocks') }}" class="form-control shadow-none" wire:model.debounce.500ms="search">
        </div>
        <div class="input-group mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="show_all" wire:model="showFilled">
                <label class="form-check-label" for="flexSwitchCheckDefault">
                    {{ __('Show only stocks with products') }}
                </label>
            </div>
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($stocks as $stock)
            <livewire:stocks.item :stock="$stock" wire:key="stock_{{ $stock->id }}_{{ now()->timestamp }}" />
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>
</div>
