@extends('Backend.layouts.app')
@section('title', 'Role Management')
@section('menu-open', 'menu-open')
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manage Roles</h4>
                <x-create_modal dataTable="roles" title="Add New Roles">
                    <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
                        ➕ Add New User
                    </button>
                </x-create_modal>
            </div>
            @include('Backend.components.Toast')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Users Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->display_name }}</td>
                                                <td>{{ $role->description }}</td>
                                                <td>{{ $role->users_count }}</td>
                                                <td>{{ $role->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <x-update-modal dataTable="roles" title="Update roles">
                                                            <button type="button" class="btn btn-outline-primary btn-sm btn-user"
                                                                data-id="{{ $role->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#updateModal" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        </x-update-modal>
                                                    </div>
                                                    @if(!$role->is_protected)
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="confirmDelete({{ $role->id }}, 'roles')" title="Delete">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    @endif
                                </div>
                                </td>
                                </tr>
                            @empty
                    <tr>
                        <td colspan="7" class="text-center">No roles found.</td>
                    </tr>
                @endforelse
                </tbody>
                </table>
            </div>

            {{ $roles->links() }}
        </div>
    </div>
    </div>



    @push('styles')
        <style>
            .table th {
                background-color: #343a40;
                color: white;
            }

            .btn-group {
                gap: 5px;
            }

            .delete-form {
                display: inline;
            }
        </style>
    @endpush

    <script src="{{ asset('js/ajax.js')}}"></script>

    <script>
        $(document).ready(function () {
            EditById($('.btn-roles'), 'roles');
        });
    </script>

@endsection