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
    <p>
        {{ __('ID in parent system - ').$stock->shop_id }}
    </p>

    <a href="{{ route('stock-products', ['stock' => $stock]) }}" class="btn btn-primary">
        {{ __('To products') }}
    </a>
</div>
