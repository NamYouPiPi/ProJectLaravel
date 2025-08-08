@props(['dataTable' => 'default', 'title' => 'default'])

<div {{ $attributes }}>
    {{ $slot }}
</div>
{{--             ------------ modal update -------------------- --}}
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="#editModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModal">{{$title}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @switch($dataTable)
                    @case("supplier")
                        @include('supplier.edit')
                        @break
                    @case('inventory')
                        @include('Inventory.edit')
                        @break
                    @default
                        <div>No data available</div>
                @endswitch
            </div>

        </div>
    </div>
</div>

{{--             ------------ end modal update ----------------- --}}
