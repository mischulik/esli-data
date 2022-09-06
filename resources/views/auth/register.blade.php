@section('title', __('Register'))

<div class="d-grid mx-auto text-center">
    <form wire:submit.prevent="register">
        <h3 class="text-light">
            @yield('title')
        </h3>
        <div class="card-body pb-0">
            <div class="col-lg-6 col-md-8 col-sm-10 mb-3 d-block mx-auto">
                <input class="form-control shadow-none @error('name') {{ 'is_invalid' }}@enderror"
                       type="text" wire:model.defer="model.name" placeholder="{{ __('Name') }}"
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 col-md-8 col-sm-10 mb-3 d-block mx-auto">
                <input class="form-control shadow-none @error('email') {{ 'is_invalid' }}@enderror"
                       type="email" wire:model.defer="model.email" placeholder="{{ __('Email') }}"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 col-md-8 col-sm-10 mb-3 d-block mx-auto">
                <input class="form-control shadow-none @error('password') {{ 'is_invalid' }}@enderror"
                       type="password" wire:model.defer="model.password" placeholder="{{ __('Password') }}"
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 col-md-8 col-sm-10 mb-3 d-block mx-auto">
                <input class="form-control shadow-none @error('password_confirmation') {{ 'is_invalid' }}@enderror"
                       type="password" wire:model.defer="model.password_confirmation" placeholder="{{ __('Confirm Password') }}"
                >
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
