@section('title', __('Welcome'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('welcome') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>
        </ol>
    </nav>
    <h1 class="mb-3">@yield('title')</h1>

<livewire:elsie-search :code="$search['code']"/>

{{--<div class="d-grid w-100 mx-auto">--}}
{{--    <h5 class="text-light">--}}
{{--        @yield('title')--}}
{{--    </h5>--}}


{{--    <livewire:elsie-search />--}}

{{--</div>--}}
