<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="{{ route('welcome') }}" class="navbar-brand">
            <img src="{{ url('images/elsie_logo.png') }}" height="24" alt="{{ config('app.name') }}'s Logo"/>
            <span class="" title="{{ __('Services State') }}">
                <i class="fa fa-circle {{ $serviceState ? 'text-success' : 'text-danger' }}"></i>
            </span>

            @auth
            <span class="" title="{{ __('Is logged in') }}">
                <i class="fa fa-circle {{ $isLoggedIn ? 'text-success' : 'text-danger' }}"></i>
            </span>
            @endauth
        </a>

        <button type="button" class="navbar-toggler shadow-none" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon shadow-none"></span>
        </button>

        <div id="nav" class="collapse navbar-collapse">
            <div class="navbar-nav ms-auto">
                @guest
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" class="nav-link">{{ __('Login') }}</a>
                    @endif
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link">{{ __('Register') }}</a>
                    @endif
                @else
                    <div class="nav-item dropdown">
                        <span class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            {{ __('Settings') }}
                        </span>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            @forelse($menuitems as $menuitem)
                                <a class="dropdown-item" href="{{ route($menuitem) }}">
                                    {{ __(ucfirst($menuitem)) }}
                                </a>
                            @empty
                            @endforelse
                        </div>
                    </div>


                    <div class="nav-item dropdown">
                        <span class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </span>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <x-ui::dropdown-item :label="__('Update Profile')"
                                                 click="$emit('showModal', 'auth.profile-update')"/>

                            <x-ui::dropdown-item :label="__('Change Password')"
                                                 click="$emit('showModal', 'auth.password-change')"/>

                            <x-ui::dropdown-item :label="__('Logout')" click="logout"/>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
