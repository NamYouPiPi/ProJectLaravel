@props([
    'dataTable' => 'default',
    'title' => 'update record',
    'showtime' => null
])

<div {{ $attributes }}>
    {{ $slot }}
</div>

<div id="updateModal" class="modal fade" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             @switch($dataTable)
                    @case('movies')
                        @include('Backend.Movies.edit')
                        @break
                    @case('supplier')
                        @include('Backend.supplier.edit')
                        @break
                    @case('inventory')
                        @include('Backend.Inventory.edit')
                        @break
                    @case('sale')
                        @include('Backend.ConnectionSale.edit')
                        @break
                    @case('genre')
                        @include('Backend.Genre.edit')
                        @break
                    @case('classification')
                        @include('Backend.Classification.edit')
                        @break
                    @case('hall_location')
                        @include('Backend.Hall_Location.edit')
                        @break
                   @case('showTimes')
                        @include('Backend.Showtime.edit', ['showtime' => $showtime])
                        @break
                    @case('SeatsType')
                        @include('Backend.SeatsType.edit')
                        @break
                    @case('seats')
                        @include('Backend.Seats.edit')
                        @break
                    @case('customer')
                        @include('Customers.create')
                        @break
                    @case('employees')
                        @include('Backend.Employees.create')
                        @break
                    @case('user')
                        @include('ManagementEmployee.User.create')
                        @break
                    @case('roles')
                        @include('ManagementEmployee.Role.create')
                        @break
                    @default
                        <div>No data available</div>
                @endswitch

            </div>
        </div>
    </div>
</div>

