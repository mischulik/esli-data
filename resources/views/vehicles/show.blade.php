@section('title', implode(' ', [$vehicle->name, implode('-', [$vehicle->year_start, $vehicle->year_end]), implode(', ', $vehicle->bodytypes)]))

<div>
    <h1>@yield('title')</h1>

    <div class="list-group mb-3">
        @forelse($products as $product)
            <livewire:products.item :product="$product"
                                    wire:key="{{ implode('_', ['product', $loop->index, $product->id]) }}"
            />
        @empty
            <div>{{ __('No products found') }}</div>
        @endforelse
    </div>

    <x-ui::pagination :links="$products"/>
</div>
