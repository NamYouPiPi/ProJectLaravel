@props(['dataTable' => 'default', 'title' => 'Add New Record'])

<div {{ $attributes }}>
    {{ $slot }}
</div>

<div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @switch($dataTable)
                    @case("supplier")
                        @include('Backend.supplier.create')
                        @break
                    @case('inventory')
                        @include('Backend.inventory.create',['suppliers' => $suppliers])
                        @break
                    @case('sale')
                        @include('Backend.ConnectionSale.create',['inventories'=>$inventories])
                        @break
                    @case('genre')
                        @include("Backend.Genre.create")
                        @break
                    @case('classification')
                        @include("Backend.Classification.create")
                        @break
                    @case('movies')
                        @include("Backend.Movies.create",['suppliers' => $suppliers, 'genres' => $genres, 'classifications' => $classifications])
                        @break
                    @case('hall_location')
                        @include("Backend.Hall_Location.create"  )
                        @break
                    @default
                        <div>No data available</div>
                @endswitch
            </div>
        </div>
    </div>
</div>

{{-- <script src="{{asset('js/ajax.js')}}"></script> --}}
