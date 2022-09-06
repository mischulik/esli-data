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

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Stocks') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
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
