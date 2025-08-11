{{--@props(['dataTable' => 'default', 'title' => 'default'])--}}

{{--<div {{ $attributes }}>--}}
{{--    {{ $slot }}--}}
{{--</div>--}}
{{--             ------------ modal update -------------------- --}}
{{--<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="#editModal" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-lg">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h1 class="modal-title fs-5" id="updateModal">{{$title}}</h1>--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                @switch($dataTable)--}}
{{--                    @case("supplier")--}}
{{--                        @include('Backend.supplier.edit')--}}
{{--                        @break--}}
{{--                    @case('inventory')--}}
{{--                        @include('Backend.Inventory.edit')--}}
{{--                        @break--}}
{{--                    @case('sale')--}}
{{--                       @include('Backend.ConnectionSale.edit')--}}
{{--                        @break--}}
{{--                    @default--}}
{{--                        <div>No data available</div>--}}
{{--                @endswitch--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@props(['dataTable' => 'default', 'title' => 'default'])

<div {{ $attributes }}>
    {{ $slot }}
</div>
{{-- ------------ modal update -------------------- --}}
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">{{$title}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @switch($dataTable)
                    @case("supplier")
                        @include('Backend.supplier.edit')
                        @break
                    @case('inventory')
                        @include('Backend.Inventory.edit')
                        @break
                    @case('sale')
                        @include('Backend.ConnectionSale.edit')
                        @break
                    @case('genre')
                        @include("Backend.Genre.edit")
                        @break
                    @case('classification')
                        @include("Backend.Classification.edit")
                        @break
                    @default
                        <div>No data available</div>
                @endswitch
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ------------ end modal update ----------------- --}}
{{--             ------------ end modal update ----------------- --}}
