@section('title', __('Home'))

<div class="d-grid w-100 mx-auto">
    <h1 class="mb-3">@yield('title')</h1>
    <livewire:elsie-search :codeSearch="request()->get('code') ?? ''" :nameSearch="request()->get('name') ?? ''"/>
</div>
