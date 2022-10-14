@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @livewireChartsScripts
    @endpush
@endonce

<div>
    {{-- Be like water. --}}
    <div class="shadow rounded p-4 border bg-white mb-3" style="height: 32rem">
        @if($needsToShow > 0)
            @livewire('livewire-line-chart', ['key' => $pricesChartModel->reactiveKey(), 'lineChartModel' => $pricesChartModel, ])
        @endif
    </div>
</div>
