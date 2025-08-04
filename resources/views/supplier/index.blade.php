@extends('layouts.app')
@section('content')
{{-- ============ add title and active =======================--}}
@section('title', 'supplier')
@section('supplier', 'active')
@section('menu-open', 'menu-open')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--================= end of add title and active ==============--}}

    {{-- Alert Container for AJAX responses --}}
    <div id="alert-container"></div>

    {{-- ================== check message add and update if succeed =======================--}}
    @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
        {{--
        <script>--}}
            {
                { --setTimeout(function () { --}}
                { { --                const alertBox = document.getElementById('success-alert'); --} }
                {
                    { --                if (alertBox) { --} }
                    { { --alertBox.style.display = 'none'; --} }
                    { { --                } --}
                }
                {
                    { --            }, 2000); // 2 seconds--}}
                    {
                        {
{{--                            --        </script>--}}
    @endif
    {{-- ======================= end of check messange ========================= --}}

    {{-- ============ input search ========================== --}}
    <form method="GET" action="{{ route('suppliers.index') }}" class="mb-3 m-3">
        <div class="float-start d-flex gap-3 ">
            <input type="text " name="search" class="form-control" id="exampleFormControlInput1" placeholder="Search here "
                value="{{ $search }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Reset</a>
        </div>
        <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#createModal"
            id="add">Add New</button>
    </form>
    {{--=============== end of search ===========================--}}

    {{-- ======== button modal for create a suppliers ======================= --}}

    <!-- Modal CREATE -->
    <div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add New Supplier Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('supplier.create')
                </div>
                <div class="modal-footer">
                    <!-- Optional Save Button or Actions -->
                </div>
            </div>
        </div>
    </div>
    {{-- ======= End of modal add Suppliers ================= --}}

    {{-- ============ Modal UPDATE ====================--}}
    <div id="updateModal" class="modal fade" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit form will be loaded here via AJAX -->
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Footer content if needed -->
                </div>
            </div>
        </div>
    </div>
    {{-- ================ end Of Modal Update ================== --}}

    {{-- ================ Table for Suppliers detail all ===================== --}}
    <div class="table-responsive">
        <table class="table table-bordered" id="suppliersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Contact Person</th>
                    <th>Supplier Type</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr id="supplier-row-{{ $supplier->id }}">
                        <td>{{ $supplier->id }}</td>
                        <td class="supplier-name">{{ $supplier->name }}</td>
                        <td class="supplier-email">{{ $supplier->email }}</td>
                        <td class="supplier-phone">{{ $supplier->phone }}</td>
                        <td class="supplier-contact">{{ $supplier->contact_person }}</td>
                        <td class="supplier-type">{{ $supplier->supplier_type }}</td>
                        <td class="supplier-status">{{ $supplier->status }}</td>
                        <td class="supplier-address">{{ $supplier->address }}</td>
                        <td>{{ $supplier->created_at->format("Y/m/d") }}</td>
                        <td class="supplier-updated">{{ $supplier->updated_at->format("Y/m/d") }}</td>
                        <td>
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info btn-sm">View</a>
                            <button type="button" class="btn btn-warning btn-sm editSupplierBtn" data-id="{{ $supplier->id }}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm deleteSupplierBtn" data-id="{{ $supplier->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{--================== pagination ====================--}}
    <div class="flex justify-center mt-1">
        {{ $suppliers->links() }}
    </div>
    {{-- ================ end of pagination ================--}}

    {{--================= Delete Confirmation Modal =========================--}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this supplier?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script>
                $(document).ready(function () {
                                // Setup CSRF token for all AJAX requests
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                let currentSupplierId = null;

                                // Show alert function
                                function showAlert(message, type = 'success') {
                                    const alertHtml = `
                                        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                            ${message}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    `;
                                    $('#alert-container').html(alertHtml);

                                    // Auto hide after 3 seconds
                                    setTimeout(() => {
                                        $('.alert').alert('close');
                                    }, 3000);
                                }

                                // Edit Supplier Button Click
                                $('.editSupplierBtn').on('click', function () {
                                    let id = $(this).data('id');
                                    currentSupplierId = id;

                                    // Show loading spinner
                                    $('#updateModal .modal-body').html(`
                                        <div class="text-center">
                                            <div class="spinner-border" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    `);

                                    // Show modal first
                                    $('#updateModal').modal('show');

                                    // Load edit form via AJAX
                                    $.ajax({
                                        url: '/suppliers/' + id + '/edit',
                                        type: 'GET',
                                        success: function (response) {
                                            $('#updateModal .modal-body').html(response);
                                        },
                                        error: function (xhr) {
                                            $('#updateModal .modal-body').html(
                                                '<div class="alert alert-danger">Error loading supplier data. Please try again.</div>'
                                            );
                                            console.error('Error loading edit form:', xhr);
                                        }
                                    });
                                });

                                $(document).on('submit', '#updateSupplierForm', function (e) {
                                    e.preventDefault();

                                    let form = $(this);
                                    let formData = new FormData(this);
                                    let id = formData.get('id') || currentSupplierId;

                                    // Disable submit button to prevent double submission
                                    form.find('button[type="submit"]').prop('disabled', true).text('Updating...');

                                    $.ajax({
                                        url: '/suppliers/' + id,
                                        type: 'POST',
                                        data: form.serialize() + '&_method=PUT',
                                        processData: false,
                                        success: function (response) {
                                            console.log('Update response:', response);
                                            $('#updateModal').modal('hide');
                                            showAlert('Supplier updated successfully!', 'success');

                                            // Update the table row with new data
                                            if (response.supplier) {
                                                updateTableRow(response.supplier);
                                            } else {
                                                // Fallback: reload the page
                                                setTimeout(() => location.reload(), 1000);
                                            }
                                        },
                                        error: function (xhr) {
                                            // Re-enable submit button
                                            form.find('button[type="submit"]').prop('disabled', false).text('Update Supplier');

                                            if (xhr.status === 422) {
                                                // Validation errors
                                                let errors = xhr.responseJSON.errors;
                                                displayValidationErrors(form, errors);
                                            } else {
                                                showAlert('Error updating supplier. Please try again.', 'danger');
                                                console.error('Update error:', xhr);
                                            }
                                        }
                                    });



                                });

                                // Delete Supplier
                                $('.deleteSupplierBtn').on('click', function () {
                                    currentSupplierId = $(this).data('id');
                                    $('#deleteModal').modal('show');
                                });

                                // Confirm Delete
                                $('#confirmDeleteBtn').on('click', function () {
                                    if (currentSupplierId) {
                                        $.ajax({
                                            url: '/suppliers/' + currentSupplierId,
                                            type: 'DELETE',
                                            success: function (response) {
                                                $('#deleteModal').modal('hide');
                                                showAlert('Supplier deleted successfully!', 'success');
                                                $('#supplier-row-' + currentSupplierId).fadeOut(function () {
                                                    $(this).remove();
                                                });
                                            },
                                            error: function (xhr) {
                                                $('#deleteModal').modal('hide');
                                                showAlert('Error deleting supplier. Please try again.', 'danger');
                                                console.error('Delete error:', xhr);
                                            }
                                        });
                                    }
                                });

                                // Function to update table row with new data
                                function updateTableRow(supplier) {
                                    let row = $('#supplier-row-' + supplier.id);
                                    if (row.length) {
                                        row.find('.supplier-name').text(supplier.name);
                                        row.find('.supplier-email').text(supplier.email);
                                        row.find('.supplier-phone').text(supplier.phone);
                                        row.find('.supplier-contact').text(supplier.contact_person);
                                        row.find('.supplier-type').text(supplier.supplier_type);
                                        row.find('.supplier-status').text(supplier.status);
                                        row.find('.supplier-address').text(supplier.address);
                                        row.find('.supplier-updated').text(new Date().toLocaleDateString('en-CA'));

                                        // Add a highlight effect
                                        row.addClass('table-success');
                                        setTimeout(() => {
                                            row.removeClass('table-success');
                                        }, 2000);
                                    }
                                }

                                // Function to display validation errors
                                function displayValidationErrors(form, errors) {
                                    // Clear previous errors
                                    form.find('.is-invalid').removeClass('is-invalid');
                                    form.find('.invalid-feedback').remove();
                                    form.find('.alert-danger').remove();

                                    // Display errors
                                    let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                                    $.each(errors, function (field, messages) {
                                        // Add error to input field
                                        let input = form.find('[name="' + field + '"]');
                                        input.addClass('is-invalid');

                                        // Add error message after input
                                        input.after('<div class="invalid-feedback">' + messages[0] + '</div>');

                                        // Add to general error list
                                        errorHtml += '<li>' + messages[0] + '</li>';
                                    });
                                    errorHtml += '</ul></div>';

                                    // Add general error list at top of form
                                    form.prepend(errorHtml);
                                }

                                // Clear form validation when modal is hidden
                                $('#updateModal').on('hidden.bs.modal', function () {
                                    $(this).find('.is-invalid').removeClass('is-invalid');
                                    $(this).find('.invalid-feedback').remove();
                                    $(this).find('.alert').remove();
                                });
                            });
    </script>

@endsection
