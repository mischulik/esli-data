<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="shadow rounded p-4 border bg-white mb-3" style="height: 32rem;">
        <livewire:livewire-line-chart key="{{ $lineChartModel->reactiveKey() }}" :line-chart-model="$lineChartModel" />
    </div>
</div>
