<div class="d-block">
    <div class="d-inline-flex justify-content-between align-items-center w-100">
        <div class="flex-grow-1">
            <h1>{{ $product->elsie_code }}</h1>
            <p class="fs-3">{{ $product->name }}</p>
        </div>
    </div>
    <div class="my-3 row">
        <livewire:products.vehicle :vehicle="$product->vehicle"/>
        <livewire:products.manufacturer :manufacturer="$product->manufacturer"/>
    </div>
</div>
