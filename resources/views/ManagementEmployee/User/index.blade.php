@extends('Backend.layouts.app')
@section('content')
@section('title', 'Users Management')
@section('user', 'active')
@section('user-menu-open', 'menu-open')

    {{-- Toast notifications --}}
    @include('Backend.components.Toast')



    {{-- Filter Section --}}
    <div class="d-flex justify-content-between p-3">
        {{-- Add New User Button --}}
        <h2>Management users </h2>
        <x-create_modal dataTable="user" title="Add New User">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                ➕ Add New User
            </button>
        </x-create_modal>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table id="example" class="display table table-responsive table-hover" style="width:100%">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Profile</th>
                        <th>bio</th>
                        {{-- <th></th> --}}
                        <th>Status</th>
                        <th>Created</th>
                        {{-- <th>Updated</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="text-center">
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" class="rounded-circle me-2" width="32" height="32">
                                    @else
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                            style="width: 32px; height: 32px;">
                                            <span class="text-white small">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role)
                                    <span class="badge bg-info me-1">{{ $user->role->name }}</span>
                                @else
                                    <span class="badge bg-secondary">No Role</span>
                                @endif
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $user->profile_image) }}" width="50" height="50"
                                    class="rounded-circle" alt="">
                            </td>
                            <td>
                                {{ $user->bio }}
                            </td>
                            <td>
                                @if ($user->is_active ?? true)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            {{-- <td>{{ $user->updated_at->format('Y-m-d') }}</td> --}}
                            <td>
                                <div class="btn-group gap-2" role="group">

                                    {{-- Edit Button --}}
                                    <x-update-modal dataTable="user" title="Update User">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-user"
                                            data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#updateModal"
                                            title="Edit">
                                            {{-- <i class="bi bi-pencil"></i>
                                            --}}
                                            edit
                                        </button>
                                    </x-update-modal>
                                    @if(Auth::id() !== $user->id)
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="confirmDelete({{ $user->id }}, 'users')" title="Delete">
                                            {{-- <i class="bi bi-trash3"></i> --}}
                                            del
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center m-4">
        <div class="text-muted">
            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
        </div>
        {{ $users->appends(request()->query())->links() }}
    </div>

    {{-- JavaScript for confirmation dialogs --}}
    <script>
        function confirmImpersonate(userId, userName) {
            Swal.fire({
                title: 'Impersonate User?',
                text: `Are you sure you want to impersonate ${userName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, impersonate!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/users/${userId}/impersonate`;
                }
            });
        }

        function toggleUserStatus(userId) {
            Swal.fire({
                title: 'Toggle User Status?',
                text: 'This will activate/deactivate the user account.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, toggle!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/users/${userId}/toggle-status`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PATCH';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        $(document).ready(function () {
            EditById($('.btn-user'), 'users');
        });
    </script>

    {{-- Include Ajax file --}}
    <script src="{{ asset('js/ajax.js')}}"></script>
@endsection
