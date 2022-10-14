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

    <livewire:products.header :product="$product" />

{{--    @if($product->prices_count > 1)--}}
    @livewire('products.prices-chart', ['product' => $product, 'title' => __('Price Dynamic of :productName', ['productName' => $this->product->elsie_code]), ])
{{--    @endif--}}

{{--    <livewire:products.prices-chart :product="$product" :title="$chartTitle" />--}}

{{--    <div class="d-block w-100">--}}
{{--        <div class="d-flex align-items-start w-100">--}}
{{--            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">--}}
{{--                @forelse($product->stock_products as $stockProduct)--}}
{{--                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"--}}
{{--                            id="v-pills-stock-{{ $stockProduct->stock->id }}-tab" data-bs-toggle="pill"--}}
{{--                            data-bs-target="#v-pills-stock-{{ $stockProduct->stock->id }}" type="button" role="tab"--}}
{{--                            aria-controls="v-pills-stock-{{ $stockProduct->stock->id }}" aria-selected="true">--}}
{{--                        {{ $stockProduct->stock->name }} ({{ $stockProduct->actual_quantity->quantity }})--}}
{{--                    </button>--}}
{{--                @empty--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--            <div class="tab-content flex-grow-1" id="v-pills-tabContent">--}}
{{--                @forelse($product->stock_products as $stockProduct)--}}
{{--                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}"--}}
{{--                         id="v-pills-stock-{{ $stockProduct->stock->id }}" role="tabpanel"--}}
{{--                         aria-labelledby="v-pills-stock-{{ $stockProduct->stock->id }}-tab" tabindex="0">--}}
{{--                        <livewire:stock-products.quantities-chart :line-chart-model="$qChartModels[$loop->index]"--}}
{{--                                                                  :stockProduct="$stockProduct" :title="123"/>--}}
{{--                    </div>--}}
{{--                @empty--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
