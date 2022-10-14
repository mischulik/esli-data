<div wire:ignore.self>
    <button class="btn btn-link border-0 shadow-none text-muted" type="button" data-bs-toggle="offcanvas" data-bs-target="#searchForm" aria-controls="searchForm">
        <i class="fas fa-filter fa-2x"></i>
    </button>

    <div class="offcanvas offcanvas-start" data-bs-backdrop="true" tabindex="-1" id="searchForm" aria-labelledby="searchFormLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="searchFormLabel">
                {{ __('Search') }}
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="flex-wrap row justify-content-between my-2">
                <div class="mb-3 mb-sm-0 col flex-sm-grow-1 flex-fill">
                    <div class="input-group">
                        <span class="input-group-text">
                            <x-ui::icon name="search"/>
                        </span>
                        <input type="search" placeholder="{{ __('Search Products') }}"
                               class="form-control shadow-none" wire:model.debounce.500ms="search">
                    </div>
                </div>
                <div class="mb-3 mb-sm-0 w-sm-auto flex-sm-shrink-1 flex-fill form-floating">
                    <div class="input-group flex-nowrap">
                        @foreach($gaFilterValues as $scope)
                            <button class="btn flex-fill shadow-none {{ $selectedGaFilter === $scope ? 'btn-secondary' : 'btn-outline-secondary' }}"
                                    type="button" wire:click="$set('selectedGaFilter', '{{ $scope }}')">
                                <span class="d-md-block d-none">
                                    {{ __(ucfirst($scope)) }}
                                </span>
                                <span class="d-block d-md-none">
                                    {{ __(ucfirst($scope)) }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex-grow-1 mb-3">
                <div class="input-group flex-nowrap">
                    @foreach($placements as $placement)
                        <button class="btn flex-fill shadow-none {{ $selectedPlacement === $placement ? 'btn-secondary' : 'btn-outline-secondary' }}"
                                type="button" wire:click="$set('selectedPlacement', '{{ $placement }}')">
                                <span class="d-md-block d-none">
                                    {{ __(implode(' ', ['Placement', $placement])) }}
                                </span>
                            <span class="d-block d-md-none">
                                {{ empty($placement) ? __('All') : $placement }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
