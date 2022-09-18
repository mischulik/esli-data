<div class="col">
    <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}" class="text-decoration-none col" title="{{ __('View all products of :vehicleName', ['vehicleName' => $vehicle->full_name]) }}">
        <div class="d-flex align-items-center text-secondary">
            <div class="flex-shrink-0">
                <i class="fa fa-2x fa-car-alt text-secondary"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <div>{{ $vehicle->name }}
                    ({{ $vehicle->year_start }}-{{ $vehicle->year_stop ?? __('now') }})
                    {{ implode(', ', $vehicle->bodytypes) }}
                </div>
                <div>{{ $vehicle->code }}</div>
            </div>
        </div>
    </a>`
</div>
