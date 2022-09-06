@section('title', __('Manufacturers'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('manufacturers') }}" class="text-decoration-none text-black">
                    {{ __('Manufacturers') }}
                </a>
            </li>
        </ol>
    </nav>

    <h1>@yield('title')</h1>

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Manufacturers') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
        {{--        <div class="col-lg-auto mb-3">--}}
        {{--            <button type="button" class="btn btn-primary" wire:click="$emit('showModal', 'manufacturers.save')">--}}
        {{--                <x-ui::icon name="plus"/> {{ __('Create') }}--}}
        {{--            </button>--}}

        {{--            <x-ui::dropdown icon="sort" :label="__($sort)">--}}
        {{--                @foreach($sorts as $sort)--}}
        {{--                    <x-ui::dropdown-item :label="__($sort)" click="$set('sort', '{{ $sort }}')"/>--}}
        {{--                @endforeach--}}
        {{--            </x-ui::dropdown>--}}

        {{--            <x-ui::dropdown icon="filter" :label="__($filter)">--}}
        {{--                @foreach($filters as $filter)--}}
        {{--                    <x-ui::dropdown-item :label="__($filter)" click="$set('filter', '{{ $filter }}')"/>--}}
        {{--                @endforeach--}}
        {{--            </x-ui::dropdown>--}}
        {{--        </div>--}}
    </div>

    <div class="list-group mb-3">
        @forelse($manufacturers as $manufacturer)
            <div class="list-group-item list-group-item-action">
                <div class="d-inline-flex align-items-center justify-content-between w-100">
                    <div class="flex-grow-1 mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('manufacturers.show', ['manufacturer' => $manufacturer]) }}"
                                   class="text-decoration-none text-dark {{ $manufacturer->glasses_count === 0 || $manufacturer->accessories_count === 0 ? 'disabled' : '' }}"
                                   title="{{ $manufacturer->name.' '.__('products') }}">
                                    <strong>
                                        {{ $manufacturer->name }}
                                    </strong>
                                    <span class="fi fi-{{ $manufacturer->country_code }}"></span>
                                </a>
                            </li>
                            <li>
                                <span title="{{ __('code suffix') }}">
                                    {{ $manufacturer->code_suffix }} <small class="text-secondary">{{ $manufacturer->country }}</small>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-auto flex-shrink-1 d-inline-flex justify-content-around">
                        @forelse(['glasses', 'accessories'] as $scope)
                        <div class="text-center d-block {{ $loop->first && $loop->count > 1 ? 'px-2' : ''}}">
                            <div class="fw-bold {{ $loop->first ? 'text-primary' : 'text-info' }}">
                                {{ $manufacturer->products()->$scope()->count() }}
                            </div>
                            <div class="text-secondary">
                                <small>{{ implode('', [__($scope), ' ', __('associated')]) }}</small>
                            </div>
                        </div>
                        @empty
                        @endforelse
                        {{--                        <x-ui::action icon="eye" :title="__('Read')"--}}
                        {{--                                      click="$emit('showModal', 'manufacturers.read', {{ $manufacturer->id }})"/>--}}

                        {{--                        <x-ui::action icon="pencil-alt" :title="__('Update')"--}}
                        {{--                                      click="$emit('showModal', 'manufacturers.save', {{ $manufacturer->id }})"/>--}}

                        {{--                        <x-ui::action icon="trash-alt" :title="__('Delete')" click="delete({{ $manufacturer->id }})"--}}
                        {{--                                      onclick="confirm('{{ __('Are you sure?') }}') || event.stopImmediatePropagation()"/>--}}
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>
</div>
