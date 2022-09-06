@section('title',  $stock->name)

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('stocks') }}" class="text-decoration-none text-secondary">
                    {{ __('Stocks') }}
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('stocks.show', ['stock' => $stock]) }}" class="text-decoration-none text-black">
                    {{ $stock->name  }}
                </a>
            </li>
        </ol>
    </nav>

    <h1>@yield('title')</h1>

    <div class="list-group mb-3">
        @forelse($stockProducts as $stockProduct)
            <livewire:stock-products.item :stockProduct="$stockProduct"
                                    wire:key="{{ implode('_', ['product', $loop->index, $stockProduct->product->id]) }}"
            />
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$stockProducts"/>
</div>
