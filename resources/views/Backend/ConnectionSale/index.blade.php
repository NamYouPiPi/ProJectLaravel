@extends('Backend.layouts.app')
@section('content')
@section('title', 'sale ')
@section('sale ', 'active')
@section('menu-open', 'menu-open')


    {{-- add message toast --}}
    @include('Backend.components.Toast')

    {{-- end message toast --}}

    {{------------modal for generator a report for sale history ------------------}}
    <div class="d-flex justify-content-between align-items-center mb-3 m-2">
        <div>
            <!-- Generate Report Button -->
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#reportModal">
                <i class="fas fa-file-pdf"></i> Generate Report
            </button>
            <!-- Best Sellers Button -->
            <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#bestSellersModal">
                <i class="fas fa-trophy"></i> Best Sellers
            </button>
        </div>

        <x-create_modal dataTable="sale" title="Add New Sale">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New
            </button>
        </x-create_modal>
    </div>
    {{--best seller --}}
    <div class="modal fade" id="bestSellersModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sale.best-sellers') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title">Best Sellers Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="best_start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="best_start_date" name="start_date">
                            </div>

                            <div class="col-md-6">
                                <label for="best_end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="best_end_date" name="end_date">
                            </div>

                            <div class="col-12">
                                <label for="limit" class="form-label">Top Items</label>
                                <select class="form-select" name="limit">
                                    <option value="5">Top 5</option>
                                    <option value="10" selected>Top 10</option>
                                    <option value="20">Top 20</option>
                                    <option value="50">Top 50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="format" value="html" class="btn btn-info me-2">View Report</button>
                        <button type="submit" name="format" value="pdf" class="btn btn-warning">Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- end best sellr--}}




    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sale.report') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate Sales Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="Date" class="form-control" id="start_date" name="start_date">
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="Date" class="form-control" id="end_date" name="end_date">
                            </div>

                            <div class="col-12">
                                <label for="inventory_id" class="form-label">Item (Optional)</label>
                                <select class="form-select" name="inventory_id">
                                    <option value="">All Items</option>
                                    @if(isset($inventories))
                                        @foreach($inventories as $inventory)
                                            <option value="{{ $inventory->id }}">{{ $inventory->item_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Generate PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-------------------- end of generator a report -------------------------}}






    {{----------------- add test sale ------------------------------}}



    <table class="table table-hover">
        <thead>
            <tr>

{{--                <th>Id</th>--}}
                <th>Item_Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Create_at</th>
                <th>Update_at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)

                <tr class="sale-row{{$sale->id}}">
{{--                    <td>{{$sale->id}}</td>--}}
                    <td>{{$sale->item_name}}</td>
                    <td>{{$sale->quantity}}</td>
                    <td>{{$sale->price}} $</td>
                    <td>{{$sale->total_price}} $</td>
                    <td>{{ $sale->created_at->format("Y/m/d") }}</td>
                    <td>{{ $sale->updated_at->format("Y/m/d") }}</td>
                    <td class="d-flex gap-3">
                        <x-update-modal dataTable="sale" title="update sale ">
                            <button type="button" class="btn btn-primary btn_edit_sale" data-id="{{$sale->id}}"
                                data-bs-toggle="modal" data-bs-target="#updateModal">Eidt
                            </button>
                        </x-update-modal>
                        <x-delete-modal dataTable="Sale" title="Delete Sale">
                            <button type="button" class="btn btn-danger btn_delete_sale" data-id="{{ $sale->id}}"
                                data-bs-toggle="modal" data-bs-target="#deletemodal">
                                Delete
                            </button>
                        </x-delete-modal>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <div class="mt-4 d-flex justify-content-center align-items-center">
        {{$sales->links()}}
    </div>
    <script src="{{asset('js/ajax.js')}}"></script>
    <script>
        $(document).ready(function () {
            EditById($('.btn_edit_sale'), 'sale');
            DeleteById($('.btn_delete_sale'), 'sale', '')
        });
    </script>
@endsection
