@section('title', __('Defaults'))

<div>
    <h1>@yield('title')</h1>

    <div class="list-group mb-3">
        @forelse(['users', 'stocks', 'vehicles', 'products'] as $item)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route($item) }}" class="text-decoration-none text-secondary">
                                    {{ ucfirst($item) }}
                                </a>
                            </li>
{{--                            <li class="small text-muted">{{  }}</li>--}}
                        </ul>
                    </div>
{{--                    <div class="col-lg-auto">--}}
{{--                        <x-ui::action icon="eye" :title="__('Read')"--}}
{{--                                      click="$emit('showModal', 'users.read', {{ $user->id }})"/>--}}

{{--                        <x-ui::action icon="pencil-alt" :title="__('Update')"--}}
{{--                                      click="$emit('showModal', 'users.save', {{ $user->id }})"/>--}}

{{--                        <x-ui::action icon="unlock-alt" :title="__('Password')"--}}
{{--                                      click="$emit('showModal', 'users.password', {{ $user->id }})"/>--}}

{{--                        <x-ui::action icon="trash-alt" :title="__('Delete')" click="delete({{ $user->id }})"--}}
{{--                                      onclick="confirm('{{ __('Are you sure?') }}') || event.stopImmediatePropagation()"/>--}}
{{--                    </div>--}}
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>
</div>
