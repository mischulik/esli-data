@section('title', __('Vehicles'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('vehicles') }}" class="text-decoration-none text-black">
                    {{ __('Vehicles') }}
                </a>
            </li>
        </ol>
    </nav>
    <h1>@yield('title')</h1>

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Vehicles') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($vehicles as $vehicle)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}"
                                   class="text-decoration-none">
                                    <strong class="text-dark">
                                        {{ $vehicle->code }}
                                    </strong>
                                    <span class="text-dark">
                                        {{ $vehicle->name }}
                                    </span>
                                    <small class="text-secondary">
                                        ({{ $vehicle->year_start }} - {{ $vehicle->year_end ?? __('now') }})
                                    </small>
                                </a>
                            </li>
                            <li>
                                @forelse($vehicle->bodytypes as $bodytype)
                                    <small class="text-secondary">{{ $bodytype }}</small>
                                @empty
                                @endforelse
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-auto text-center">
                        <div>
                            <strong class="text-primary">
                                {{ $vehicle->products_count }}
                            </strong>
                        </div>
                        <div>
                            <small class="text-secondary">
                                {{ __('products associated') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$vehicles"/>
</div>
