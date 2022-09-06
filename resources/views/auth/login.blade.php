@section('title', __('Type your credentials to login'))

<div class="d-grid mx-auto text-center">
    <form wire:submit.prevent="login">
        <h3 class="text-light">
            @yield('title')
        </h3>
        <div class="d-block mb-3">
            <span class="text-light">{{ __('or') }}</span>
            <a href="{{ route('register') }}" class="text-info text-decoration-none mb-5">
            {{__('register')}}
        </a>
        </div>
        <div class="justify-content-center flex-column w-100">
            <div class="col-lg-6 col-md-8 col-sm-10 mb-3 d-block mx-auto">
            <input class="form-control shadow-none @error('email') {{ 'is_invalid' }}@enderror"
                   type="email" wire:model.defer="model.email" placeholder="{{ __('Email') }}"
            >
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
            <div class="col-lg-6 col-md-8 col-sm-10 mb-3 d-block mx-auto">
                <input class="form-control shadow-none" type="password" wire:model.defer="model.password" placeholder="{{ __('Password') }}">
            </div>
        </div>
        <div class="d-block">
            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
        </div>
    </form>
</div>
