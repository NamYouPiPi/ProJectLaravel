@extends('Backend.layouts.app')
@section('content')
@section('title', 'Users Management')
@section('inventory', 'active')

    {{-- Toast notifications --}}
    @include('Backend.components.Toast')

    {{-- Check if impersonating --}}
    @if(session('is_impersonating'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Impersonation Mode:</strong> You are currently impersonating {{ Auth::user()->name }}.
            <a href="{{ route('impersonation.stop') }}" class="btn btn-sm btn-outline-dark ms-2">
                Stop Impersonation
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter Section --}}
    <div class="filter-section">
        {{-- Add New User Button --}}
        <x-create_modal dataTable="user" title="Add New User">
            <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
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
                                @if($user->role && $user->role->count() > 0)
                                    <span class="badge bg-info me-1">{{ $user->role->name }}</span>
                                @else
                                    <span class="badge bg-secondary">No Role</span>
                                @endif
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
                                <div class="btn-group" role="group">
                                    {{-- View Button --}}
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-outline-info btn-sm" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Edit Button --}}
                                    <x-update-modal dataTable="user" title="Update User">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-user"
                                            data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#updateModal"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </x-update-modal>

                                    {{-- Impersonate Button (Only for Super Admin and not self) --}}
                                    @can('impersonate users')
                                        @if(Auth::id() !== $user->id && !session('is_impersonating'))
                                            <button type="button" class="btn btn-outline-warning btn-sm"
                                                onclick="confirmImpersonate({{ $user->id }}, '{{ $user->name }}')" title="Impersonate">
                                                <i class="bi bi-person-check"></i>
                                            </button>
                                        @endif
                                    @endcan

                                    {{-- Toggle Status Button --}}
                                    @if(Auth::id() !== $user->id)
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="toggleUserStatus({{ $user->id }})" title="Toggle Status">
                                            <i class="bi bi-toggle-{{ $user->is_active ?? true ? 'on' : 'off' }}"></i>
                                        </button>
                                    @endif

                                    {{-- Delete Button --}}
                                    @if(Auth::id() !== $user->id)
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="confirmDelete({{ $user->id }}, 'users')" title="Delete">
                                            <i class="bi bi-trash3"></i>
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
