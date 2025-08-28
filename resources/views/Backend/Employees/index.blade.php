@extends('Backend.layouts.app')
{{-- ============ add title and active =======================--}}
@section('title', 'supplier')
@section('supplier', 'active')
{{--@section('menu-open', 'menu-open')--}}
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{--================= end of add title and active ==============--}}


    {{-- Alert Container for AJAX responses --}}
    <div id="alert-container"></div>

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')
    <x-create_modal dataTable="employees" title="Add New employees" class="">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createModal">
            Add New Employee
        </button>
    </x-create_modal>


    {{-- ================ Table for Suppliers detail all ===================== --}}
    <div class="table-responsive">
        <table class="table table-hover " id="suppliersTable">
            <thead>
                <tr>
                   <th>Name</th>
                   <th>Email</th>
                   <th>Phone</th>
                   <th>Age</th>
                   <th>Address</th>
                   <th>Gender</th>
                   <th>DOB</th>
                   <th>Hire Date</th>
                   <th>Termination Date</th>
                    <th>Position</th>
                    <th>Salary</th>
                   <th>Status</th>
                   <th>Created</th>
                   <th>Updated</th>
                   <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->age }}</td>
                        <td>{{ $employee->address }}</td>
                        <td>{{ $employee->gender }}</td>
                        <td>{{ $employee->dob }}</td>
                        <td>{{ $employee->hire_date }}</td>
                        <td>{{ $employee->termination_date }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ $employee->salary }} ​$</td>
                        <td>
                            @if($employee->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($employee->status === 'inactive')
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $employee->created_at->format('Y-m-d') }}</td>
                        <td>{{ $employee->updated_at->format('Y-m-d') }}</td>
                        <td class="d-flex gap-2">
                         <x-update-modal dataTable="employees" title="update employees">
                                <button type="button" class="btn btn-outline-primary  btn-sm btn-employees " data-id="{{$employee->id}}"
                                    data-bs-toggle="modal" data-bs-target="#updateModal">edit
                                </button>
                            </x-update-modal>

                            <button type="button" class="btn btn-outline-danger btn-sm"
                                onclick="confirmDelete({{ $employee->id }}, 'employees')">
                                del
                            </button>

                    </tr>

                @endforeach
            </tbody>

        </table>
    </div>

    {{--================== pagination ====================--}}
   <div class="d-flex justify-content-between align-items-center m-1 ">
    {{-- Results info --}}
        <div class="text-muted">
           Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} results
        </div>

           {{ $employees->appends(request()->query())->links() }}

    </div>
    {{-- ================ end of pagination ================--}}

    <Script src="{{ asset('js/ajax.js')}}"></Script>
    <script>


        $(document).ready(function () {

            EditById($('.btn-employees'), 'employees');
        });
    </script>
@endsection
