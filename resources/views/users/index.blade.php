@section('title', __('Users'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('users') }}" class="text-decoration-none text-black">
                    {{ __('Users') }}
                </a>
            </li>
        </ol>
    </nav>
    <h1>@yield('title')</h1>

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Users') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($users as $user)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>{{ $user->name }}</li>
                            <li class="small text-muted">@displayDate($user->created_at)</li>
                        </ul>
                    </div>
                    <div class="col-lg-auto">
                        <x-ui::action icon="eye" :title="__('Read')"
                                      click="$emit('showModal', 'users.read', {{ $user->id }})"/>

                        <x-ui::action icon="pencil-alt" :title="__('Update')"
                                      click="$emit('showModal', 'users.save', {{ $user->id }})"/>

                        <x-ui::action icon="unlock-alt" :title="__('Password')"
                                      click="$emit('showModal', 'users.password', {{ $user->id }})"/>

                        <x-ui::action icon="trash-alt" :title="__('Delete')" click="delete({{ $user->id }})"
                                      onclick="confirm('{{ __('Are you sure?') }}') || event.stopImmediatePropagation()"/>
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$users"/>
</div>
