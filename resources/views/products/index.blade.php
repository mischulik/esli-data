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

    @livewire('offcanvas-filters')

    <div class="list-group mb-3">
        @forelse($products as $product)
            <livewire:products.item :product="$product" wire:key="{{ implode('_', ['product', $loop->index, $product->id]) }}"/>
        @empty
            <div class="list-group-item text-center">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$products"/>
</div>
