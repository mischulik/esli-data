<div class="col">
    {{-- The whole world belongs to you. --}}
    <a href="{{ route('manufacturers.show', ['manufacturer' => $manufacturer]) }}" class="text-decoration-none col" title="{{ __('View all products by :manufacturerName', ['manufacturerName' => $manufacturer->name]) }}">
        <div class="d-flex align-items-center text-secondary">
            <div class="flex-shrink-0">
                <i class="fas fa-2x fa-industry text-secondary"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                {{ $manufacturer->name }}
                {{ $manufacturer->country }}
                <small>
                    ({{ $manufacturer->code_suffix }})
                </small>
            </div>
        </div>
    </a>
</div>
